<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class LocalizationController extends Controller
{
    public function getStrings($locale)
    {
        // config('app.locales') gives all supported locales
        if (!array_key_exists($locale, config('app.locales'))) {
            $locale = config('app.fallback_locale');
        }

        // Add locale to the cache key
        $json = \Cache::rememberForever("lang-{$locale}.js", function () use ($locale) {
            $lang = config('app.locale');

            $files = glob(resource_path('lang/' . $lang . '/*.php'));
            $data = [];

            foreach ($files as $file) {
                $name = basename($file, '.php');
                $data[$name] = require $file;
            }

            return $data;
        });

        $contents = 'window.i18n = ' . json_encode($json,
                config('app.debug', false) ? JSON_PRETTY_PRINT : 0) . ';';
        $response = \Response::make($contents, 200);
        $response->header('Content-Type', 'application/javascript');

        return $response;
    }
}
