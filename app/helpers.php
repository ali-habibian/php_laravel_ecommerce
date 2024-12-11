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

