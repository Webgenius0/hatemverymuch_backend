<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('media_url')) {
    function media_url($path)
    {
        if (!$path) {
            return null;
        }

        return Storage::url($path);
    }
}
