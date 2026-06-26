<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class HomeApiService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.backend.url');
    }

    public function getHomeData()
{
    try {
        $response = Http::timeout(10)->get("{$this->baseUrl}/home");
        
        if ($response->successful()) {
            // Return the entire JSON response as-is
            return $response->json(); 
        }
        
        return ['slider' => []];
    } catch (\Exception $e) {
        Log::error('Home API Error: ' . $e->getMessage());
        return ['slider' => []];
    }
}
}