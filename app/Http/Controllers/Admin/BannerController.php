<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

class BannerController extends Controller
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::latest()->paginate(10);

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'priority' => 'nullable|integer',
            'is_active' => 'required|boolean',
            'type' => 'required|string',
            'button_text' => 'nullable|string',
            'button_link' => 'nullable|string',
            'button_icon' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $this->fileService->uploadFile($request->file('image'), config('uploads.banner_image_path'), 'img_');

        if ($image) {
            Banner::create([
                'title' => $request->title,
                'priority' => $request->priority,
                'is_active' => $request->is_active,
                'type' => $request->type,
                'button_text' => $request->button_text,
                'button_link' => $request->button_link,
                'button_icon' => $request->button_icon,
                'description' => $request->description,
                'image' => $image,
            ]);
        } else {
            return redirect()->back()->with('error', 'مشکلی در آپلود تصویر رخ داده است، لطف دوباره سعی کنید.');
        }

        return redirect()->route('admin.banners.index')->with('success', 'بنر با موفقیت اضافه شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string',
            'priority' => 'nullable|integer',
            'is_active' => 'required|boolean',
            'type' => 'required|string',
            'button_text' => 'nullable|string',
            'button_link' => 'nullable|string',
            'button_icon' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $previousImage = $banner->image;
            $image = $this->fileService->uploadFile($request->file('image'), config('uploads.banner_image_path'), 'img_');
            if ($image) {
                $this->fileService->deleteFile($previousImage);
                $banner->update([
                    'image' => $image,
                ]);
            } else {
                return redirect()->back()->with('error', 'مشکلی در آپلود تصویر رخ داده است، لطف دوباره سعی کنید.');
            }
        }

        $banner->update([
            'title' => $request->title,
            'priority' => $request->priority,
            'is_active' => $request->is_active,
            'type' => $request->type,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'button_icon' => $request->button_icon,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'بنر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        // Validate the banner object
        if (!$banner->exists) {
            return redirect()->route('admin.banners.index')->with('error', 'بنر مورد نظر یافت نشد.');
        }

        try {
            DB::beginTransaction();

            $deleteResult = $banner->delete();

            if ($deleteResult) {
                $this->fileService->deleteFile($banner->image);

                DB::commit();

                return redirect()->route('admin.banners.index')->with('success', 'بنر با موفقیت حذف شد.');
            } else {
                // Rollback the transaction if the delete operation fails
                DB::rollBack();

                return redirect()->route('admin.banners.index')->with('error', 'مشکلی در حذف بنر رخ داده است، لطف دوباره سعی کنید.');
            }
        } catch (\Exception $e) {
            // Rollback the transaction in case of any exception
            DB::rollBack();
            Log::error('Error deleting banner: ' . $e->getMessage());

            return redirect()->route('admin.banners.index')->with('error', 'مشکلی در حذف بنر رخ داده است، لطف دوباره سعی کنید.');
        }
    }

}
