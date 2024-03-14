<?php

// app/Helpers/FileHelper.php

use Illuminate\Support\Facades\Storage;

if (!function_exists('getFile')) {
    /**
     * Get the content of a file.
     *
     * @param  string  $file
     * @param  string|null  $disk
     * @return string|false
     */
    function getFile($file, $disk = null)
    {
        if ($disk) {
            return Storage::disk($disk)->get($file);
        }

        return Storage::get($file);
    }
}
if (!function_exists('getFileName')) {
    /**
     * Get the content of a file.
     *
     * @param  string  $file
     * @param  string|null  $disk
     * @return string|false
     */
    function getFileName($file, $disk = null)
    {
        if ($disk) {
            // If disk is specified, use Storage facade with the specified disk
            return basename(Storage::disk($disk)->path($file));
        }

        // If disk is not specified, use Storage facade with the default disk
        return basename(Storage::path($file));
    }
}
