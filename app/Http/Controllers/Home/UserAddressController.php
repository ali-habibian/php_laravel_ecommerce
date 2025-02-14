<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\city;
use App\Models\Province;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userAddress = auth()->user()->addresses;
        $provinces = Province::all();

        return view('home.user.profile.address', compact('userAddress', 'provinces'));
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
        $request->validateWithBag('storeAddress', [
            'title' => 'required|max:255',
            'address' => 'required|string|max:255',
            'tel' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Validator::make([$attribute => $value], ['tel' => 'ir_phone_with_code'])->passes() &&
                        !Validator::make([$attribute => $value], ['tel' => 'ir_mobile:zero'])->passes()) {
                        $fail(":attribute باید شماره تلفن ثابت با کد شهر باشد و یا شماره موبایل که با صفر شروع می‌شود.");
                    }
                },
            ],
            'postal_code' => 'required|ir_postal_code:without_seprate',
            'province_id' => 'required',
            'city_id' => 'required',
        ]);

        try {
            auth()->user()->addresses()->create([
                'title' => $request->title,
                'address' => $request->address,
                'tel' => $request->tel,
                'postal_code' => $request->postal_code,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
            ]);

            return back()->with('success', 'آدرس با موفقیت ثبت شد');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در ثبت آدرس، لطفا مجددا تلاش کنید');
        }
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
    public function update(Request $request, UserAddress $address)
    {
        $request->validateWithBag('updateAddress-' . $address->id, [
            'title' => 'required|max:255',
            'address' => 'required|string|max:255',
            'tel' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Validator::make([$attribute => $value], ['tel' => 'ir_phone_with_code'])->passes() &&
                        !Validator::make([$attribute => $value], ['tel' => 'ir_mobile:zero'])->passes()) {
                        $fail(":attribute باید شماره تلفن ثابت با کد شهر باشد و یا شماره موبایل که با صفر شروع می‌شود.");
                    }
                },
            ],
            'postal_code' => 'required|ir_postal_code:without_seprate',
            'province_id' => 'required',
            'city_id' => 'required',
        ]);

        try {
            if ($address->user_id == auth()->id()) {
                $address->update([
                    'title' => $request->title,
                    'address' => $request->address,
                    'tel' => $request->tel,
                    'postal_code' => $request->postal_code,
                    'province_id' => $request->province_id,
                    'city_id' => $request->city_id,
                ]);

                return back()->with('success', 'آدرس با موفقیت ویرایش شد');
            } else {
                throw new \Exception('خطا در ویرایش آدرس');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در ویرایش آدرس، لطفا مجددا تلاش کنید');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
