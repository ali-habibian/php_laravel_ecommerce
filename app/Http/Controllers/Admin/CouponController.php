<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'type' => 'required|in:fixed,percent',
            'amount' => 'required_if:type,fixed',
            'percent' => 'required_if:type,percent',
            'max_percentage_amount' => 'required_if:type,percent',
            'expires_at' => 'required',
            'description' => 'nullable|string',
        ], [
            'amount.required_if' => 'هنگامی که :other برابر با (مبلغی) است، فیلد :attribute الزامی است.',
            'percent.required_if' => 'هنگامی که :other برابر با (درصدی) است، فیلد :attribute الزامی است.',
            'max_percentage_amount.required_if' => 'هنگامی که :other برابر با (درصدی) است، فیلد :attribute الزامی است.',
        ])->validate();

        try {
            $gregorianExpireDate = convertShamsiToGregorian($request->expires_at);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'تاریخ نامعتبر است');
        }

        Coupon::create([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'amount' => $request->amount,
            'percent' => $request->percent,
            'max_percentage_amount' => $request->max_percentage_amount,
            'expires_at' => $gregorianExpireDate,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'کوپن با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
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
