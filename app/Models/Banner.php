<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';
    protected $guarded = [];

    /**
     * Get the string representation of the active status.
     *
     * This method converts a boolean value representing the active status into a human-readable string.
     * If the status is true, it returns 'فعال' (active), otherwise it returns 'غیر فعال' (inactive).
     *
     * @param bool $is_active The boolean value of the active status.
     * @return string The string representation of the active status.
     */
    public function getIsActiveAttribute(bool $is_active): string
    {
        return $is_active ? 'فعال' : 'غیر فعال';
    }
}
