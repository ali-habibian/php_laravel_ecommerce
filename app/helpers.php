<?php

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
