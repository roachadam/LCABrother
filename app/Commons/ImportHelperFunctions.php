<?php

namespace App\Commons;

use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\HeadingRowImport;

class ImportHelperFunctions
{
    public static function validateHeadingRow($file, $keys): bool
    {
        return count(array_intersect($keys, (new HeadingRowImport)->toArray($file)[0][0])) === count($keys) ? true : false;
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
