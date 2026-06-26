<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('api')) {
    function api($endpoint)
    {
        $response = Http::get(config('api.base_url') . $endpoint);

        if ($response->failed()) {
            return [];
        }

        return $response->json();
    }
}