<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreImage
{
    private static $fileName = '';
    private static $generatedFileName = '';

    public static function storeFile($file, $title, $folder, $disk): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $fileExtension = $file->getClientOriginalExtension();

        $oldFilenamePartial = substr($originalName, 0, 9);

        if ($title !== null || !empty($title)) {
            $postTitlePartial = substr(str_replace(' ', '', $title), 0, 9);
        } else {
            $postTitlePartial = "no_title";
        }

        self::$fileName = "{$oldFilenamePartial}.{$postTitlePartial}." . uniqid() . ".{$fileExtension}";

        $file->storeAs($folder, self::$fileName, $disk);

        self::$generatedFileName = $folder . '/' . self::$fileName;

        return self::$generatedFileName;
    }

    public static function getDirectoryFreeName(): string
    {
        return self::$fileName;
    }

    public static function getNewFileName(): string
    {
        return self::$generatedFileName;
    }

}
