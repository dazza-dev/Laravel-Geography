<?php

use Illuminate\Support\Facades\File;

if (! function_exists('getLocalesFromDirectory')) {
    /**
     * Get locales from directory.
     */
    function getLocalesFromDirectory(string $localePath): array
    {
        $locales = [];
        $files = File::files($localePath);

        foreach ($files as $file) {
            if ($file->getExtension() === 'json') {
                $localeData = jsonFileToArray($file->getRealPath());
                $locales = array_merge($locales, $localeData);
            }
        }

        return $locales;
    }
}

if (! function_exists('jsonFileToArray')) {
    /**
     * Convert JSON file to array.
     */
    function jsonFileToArray(string $filePath): array
    {
        if (! File::exists($filePath)) {
            throw new \Exception("The file {$filePath} does not exist.");
        }

        return json_decode(File::get($filePath), true);
    }
}
