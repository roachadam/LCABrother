<?php

namespace App\Commons;

use Illuminate\Support\Facades\Session;

class HelperFunctions
{
    public static function validateHeadingRow($keys, $headings): bool
    {
        return count(array_intersect($keys, $headings)) === count($keys) ? true : false;
    }

    public static function storeFileLocally($file, $path)
    {
        $filenameWithExt = $file->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);                      // Get just filename
        $extension = $file->getClientOriginalExtension();                               // Get just ext
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;                 // Filename to store TODO Figure out how to name
        $file->storeAs($path, $fileNameToStore);                                    // Save Image
    }
}
