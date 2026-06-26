<?php

if (!function_exists('getSettings')) {
    function getSettings()
    {
        static $settings = null;
        
        if ($settings === null) {
            try {
                $response = \Illuminate\Support\Facades\Http::timeout(10)
                    ->get(config('api.base_url') . '/home');
                if ($response->successful()) {
                    $data = $response->json();
                    $settings = $data['settings'] ?? null;
                }
            } catch (\Exception $e) {
                $settings = null;
            }
        }
        
        return $settings;
    }
}

if (!function_exists('getLogo')) {
    function getLogo($type = 'white_logo')
    {
        $settings = getSettings();
        
        if (!$settings) {
            return asset('assets/img/product/product-1-1.png');
        }
        
        $logo = is_object($settings) 
            ? ($settings->$type ?? null)
            : ($settings[$type] ?? null);
        
        return $logo ?: asset('assets/img/product/product-1-1.png');
    }
}