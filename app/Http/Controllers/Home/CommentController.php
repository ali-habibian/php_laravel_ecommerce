<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function userCommentsIndex()
    {
        $comments = auth()->user()->comments()->where('approved', true)->with('product')->get();
        return view('home.user.profile.comments', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|min:5|max:7000',
            'rate' => 'required|digits_between:0,5'
        ]);

        if ($validator->fails()) {
            return redirect()->to(url()->previous() . '#comments')->withErrors($validator);
        }

        if (auth()->check()) {
            DB::beginTransaction();
            try {
                $product->comments()->create([
                    'text' => $request->text,
                    'user_id' => auth()->id()
                ]);

                if ($product->productRates()->where('user_id', auth()->id())->exists()) {
                    $product->productRates()->where('user_id', auth()->id())->update([
                        'rate' => $request->rate
                    ]);
                } else {
                    $product->productRates()->create([
                        'rate' => $request->rate,
                        'user_id' => auth()->id()
                    ]);
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                return redirect()->to(url()->previous() . '#comments')->with('error', 'خطایی رخ داد');
            }
        } else {
            return redirect()->back()->with('warning', 'برای ثبت ثبت نظر شما باید ابتدا وارد سایت شوید');
        }

        return redirect()->back()->with('success', 'نظر شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
