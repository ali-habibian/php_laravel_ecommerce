<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * Uploads a file to a specified directory.
     *
     * This function is responsible for storing a given file object into a specified directory on a specified disk,
     * with the option to add a prefix to the file name. It ensures the file has a unique name to prevent overwriting
     * existing files, and handles exceptions that may occur during the file upload process.
     *
     * @param UploadedFile $file The file object to upload.
     * @param string $directory The directory where the file will be stored. Defaults to 'uploads'.
     * @param string $prefix An optional prefix for the file name. Defaults to ''.
     *
     * @return string|bool Returns the file path upon successful upload, or false if the upload fails.
     */
    public function uploadFile(UploadedFile $file, string $directory = 'uploads', string $prefix = ''): bool|string
    {
        try {
            // Generate a unique file name
            $filename = generateFileName($file, $prefix);

            // Store the file and Return the file path
            return 'storage/' . $file->storeAs($directory, $filename, 'public');
        } catch (\Exception $e) {
            // Log error and return false if something goes wrong
            Log::error('File upload error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Uploads multiple files to a specified directory and returns the paths of the uploaded files.
     *
     * @param array $files An array of files to be uploaded, usually obtained from a form.
     * @param string $directory The directory where the files will be uploaded, default is 'uploads'.
     * @param string $prefix A prefix for the file name, default is empty.
     * @return array|bool Returns an array of paths of the uploaded files on success, or false on failure.
     */
    public function uploadFiles(array $files, string $directory = 'uploads', string $prefix = ''): array|bool
    {
        // Initialize an array to store the paths of the uploaded files
        $uploadedPaths = [];

        try {
            // Iterate over each file in the array
            foreach ($files as $file) {
                // Generate a unique file name
                $filename = generateFileName($file, $prefix);

                // Store the file and get the file path
                $filePath = 'storage/' . $file->storeAs($directory, $filename, 'public');

                // Store the path in the result array
                $uploadedPaths[] = $filePath;
            }

            // Return an array of the uploaded file paths
            return $uploadedPaths;
        } catch (\Exception $e) {
            // Log error and return false if something goes wrong
            Log::error('File upload error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Deletes a specified file from the public storage disk.
     *
     * @param string $filePath The path of the file to be deleted, possibly including the 'storage/' prefix.
     * @return bool Returns true if the file was successfully deleted, otherwise false.
     */
    public function deleteFile(string $filePath): bool
    {
        try {
            // Remove 'storage/' prefix if it exists to match the actual stored path
            $relativePath = str_replace('storage/', '', $filePath);

            // Delete the file if it exists
            if (Storage::disk('public')->exists($relativePath)) {
                return Storage::disk('public')->delete($relativePath);
            }

            Log::warning('File not found: ' . $filePath);
            return false;
        } catch (\Exception $e) {
            Log::error('File deletion error: ' . $e->getMessage());
            return false;
        }
    }
}
