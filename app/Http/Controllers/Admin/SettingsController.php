<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Validator;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::first();

        if ($setting) {
            return view('admin.settings.index', compact('setting'));
        }

        return view('admin.settings.index');
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
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'phone' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!Validator::make([$attribute => $value], ['phone' => 'ir_phone_with_code'])->passes() &&
                        !Validator::make([$attribute => $value], ['phone' => 'ir_mobile:zero'])->passes()) {
                        $fail("شماره تماس باید، شماره تلفن ثابت با کد شهر باشد و یا شماره موبایل که با صفر شروع می‌شود.");
                    }
                },
            ],
            'phone_2' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!Validator::make([$attribute => $value], ['phone_2' => 'ir_phone_with_code'])->passes() &&
                        !Validator::make([$attribute => $value], ['phone_2' => 'ir_mobile:zero'])->passes()) {
                        $fail("شماره تماس باید، شماره تلفن ثابت با کد شهر باشد و یا شماره موبایل که با صفر شروع می‌شود.");
                    }
                },
            ],
            'instagram' => 'nullable|string',
            'telegram' => 'nullable|string',
            'facebook' => 'nullable|string',
            'email' => 'nullable|email',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
        ]);

        $setting = Setting::create([
            'address' => $request->address,
            'phone' => $request->phone,
            'phone_2' => $request->phone_2,
            'instagram' => $request->instagram,
            'telegram' => $request->telegram,
            'facebook' => $request->facebook,
            'email' => $request->email,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

//        return view('admin.settings.index', compact('setting'))->with('success', 'تنظیمات با موفقیت ثبت شد');
        return redirect()->route('admin.settings.index', compact('setting'))->with('success', 'تنظیمات با موفقیت ثبت شد');
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
    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'address' => 'required|string',
            'phone' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!Validator::make([$attribute => $value], ['phone' => 'ir_phone_with_code'])->passes() &&
                        !Validator::make([$attribute => $value], ['phone' => 'ir_mobile:zero'])->passes()) {
                        $fail("شماره تماس باید، شماره تلفن ثابت با کد شهر باشد و یا شماره موبایل که با صفر شروع می‌شود.");
                    }
                },
            ],
            'phone_2' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!Validator::make([$attribute => $value], ['phone_2' => 'ir_phone_with_code'])->passes() &&
                        !Validator::make([$attribute => $value], ['phone_2' => 'ir_mobile:zero'])->passes()) {
                        $fail("شماره تماس باید، شماره تلفن ثابت با کد شهر باشد و یا شماره موبایل که با صفر شروع می‌شود.");
                    }
                },
            ],
            'instagram' => 'nullable|string',
            'telegram' => 'nullable|string',
            'facebook' => 'nullable|string',
            'email' => 'nullable|email',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
        ]);

        $setting->update([
            'address' => $request->address,
            'phone' => $request->phone,
            'phone_2' => $request->phone_2,
            'instagram' => $request->instagram,
            'telegram' => $request->telegram,
            'facebook' => $request->facebook,
            'email' => $request->email,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

//        return view('admin.settings.index', compact('setting'))->with('success', 'تنظیمات با موفقیت ویرایش شد');
        return redirect()->route('admin.settings.index', compact('setting'))->with('success', 'تنظیمات با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
