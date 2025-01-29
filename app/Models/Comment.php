<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';
    protected $guarded = [];

    /**
     * Get the string representation of the approval status.
     *
     * This method converts a boolean approval status into a human-readable string format.
     * It takes a boolean parameter and returns 'تایید شده' if the parameter is true,
     * otherwise it returns 'تایید نشده'.
     *
     * @param bool $approved The boolean value representing the approval status, true for approved, false for not approved.
     * @return string The string representation of the approval status, either 'تایید شده' or 'تایید نشده'.
     */
    public function getApprovedAttribute(bool $approved): string
    {
        return $approved ? 'تایید شده' : 'تایید نشده';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
