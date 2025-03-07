<?php

use App\Models\Coupon;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

/**
 * Generates a unique file name based on the current date and time.
 *
 * This function creates a unique file name by combining an optional prefix, the current date and time formatted as 'Y_m_d_H_i_s',
 * a unique ID, and the original file extension.
 *
 * @param UploadedFile $file The file object for which the name is being generated.
 * @param string $prefix An optional prefix for the file name. Defaults to ''.
 *
 * @return string The generated unique file name.
 */
function generateFileName(UploadedFile $file, string $prefix = ''): string
{
    return $prefix . Carbon::now()->format('Y_m_d_H_i_s') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
}

/**
 * Converts a Shamsi (Jalali) date to a Gregorian date.
 *
 * @param string|null $shamsiDate The Shamsi date in 'YYYY/MM/DD' format.
 * @return DateTime|null Returns a DateTime object representing the Gregorian date, or null if the input is null.
 * @throws Exception Throws an exception if the date parsing fails.
 */
function convertShamsiToGregorian(?string $shamsiDate): ?DateTime
{
    // Return null if the input date is null
    if ($shamsiDate === null) {
        return null;
    }

    // Replace slashes with dashes in the date string to match the expected format
    $shamsiDate = str_replace('/', '-', $shamsiDate);

    // Parse the Shamsi date using the Verta library and return the corresponding Gregorian DateTime object
    return Verta::parse($shamsiDate)->datetime();
}

/**
 * Calculate the total discount amount for items in the cart.
 *
 * This function iterates over each item in the cart and calculates the total discount
 * based on the difference between the original price and the sale price of items that are on sale.
 *
 * @return float|int The total discount amount for the cart. Returns a float or int value.
 */
function cartTotalDiscountAmount(): float|int
{
    $totalDiscountAmount = 0;
    foreach (Cart::getContent() as $item) {
        if ($item->attributes->is_sale) {
            $totalDiscountAmount += $item->quantity * ($item->attributes->price - $item->attributes->sale_price);
        }
    }

    return $totalDiscountAmount;
}

/**
 * Calculate the total delivery amount for items in the cart.
 *
 * This function iterates over each item in the cart and calculates the total delivery
 * amount. It adds the base delivery amount for each item and additional delivery
 * amount per product for quantities greater than one.
 *
 * @return int The total delivery amount for the cart.
 */
function cartTotalDeliveryAmount(): int
{
    $totalDeliveryAmount = 0;
    foreach (Cart::getContent() as $item) {
        $totalDeliveryAmount += $item->associatedModel->delivery_amount;
        if ($item->quantity > 1) {
            $totalDeliveryAmount += $item->associatedModel->delivery_amount_per_product * ($item->quantity - 1);
        }
    }

    return $totalDeliveryAmount;
}

/**
 * Validates a coupon code and applies the coupon if valid.
 *
 * This function checks if a coupon with the given code exists, has not expired,
 * and has not been used by the current user before. If the coupon is valid, it
 * calculates the discount based on the coupon type (fixed or percentage) and
 * stores the discount information in the session. If the coupon is invalid or
 * already used, it throws an exception.
 *
 * @param string $code The coupon code to validate.
 * @return array An array with a success message if the coupon is applied successfully.
 * @throws Exception If the coupon is invalid or already used by the user.
 */
function validateCoupon(string $code): array
{
    if (session()->has('coupon')) {
        session()->forget('coupon');
    }

    $coupon = Coupon::where('code', $code)
        ->where('expires_at', '>', Carbon::now())
        ->firstOrFail();

    $isUserUsedCoupon = Order::where('coupon_id', $coupon->id)
        ->where('user_id', auth()->id())
        ->where('payment_status', '=', true)
        ->exists();

    if ($isUserUsedCoupon) {
        throw new Exception('شما قبلا این کد تخفیف را استفاده کرده اید', 403);
    }

    if ($coupon->getRawOriginal('type') === 'fixed') {
        session()->put('coupon', ['id' => $coupon->id, 'code' => $coupon->code, 'amount' => $coupon->amount]);
    } else {
        $total = Cart::getTotal();
        $discountAmount = ($total * $coupon->percent) / 100;
        $finalDiscountAmount = $discountAmount > $coupon->max_percentage_amount ? $coupon->max_percentage_amount : $discountAmount;

        session()->put('coupon', ['id' => $coupon->id, 'code' => $coupon->code, 'amount' => $finalDiscountAmount]);
    }

    return ['success' => 'کد تخفیف با موفقیت اعمال شد'];
}

function cartTotalAmount()
{
    $totalAmount = Cart::getTotal() + cartTotalDeliveryAmount();

    if (session()->has('coupon')) {
        if (session('coupon.amount') > $totalAmount) {
            return 0;
        } else {
            return $totalAmount - session('coupon.amount');
        }
    } else {
        return $totalAmount;
    }
}
