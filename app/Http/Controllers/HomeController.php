<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Fetch system settings from API with caching
     * Returns array or null if API fails
     */
    public  function getSystemSettings()
{
    try {
        return Cache::remember('frontend_system_settings', 3600, function () {
            $response = Http::timeout(5)->get(config('api.base_url') . '/system-setting');
            
            if ($response->successful()) {
                $data = $response->json();
                $settings = $data['systemSetting'] ?? null;
                
                if ($settings) {
                    // Normalize logo paths to include /storage/ prefix
                    if (!empty($settings['white_logo']) && !str_contains($settings['white_logo'], '/storage/')) {
    $settings['white_logo'] = str_replace('/logos/', '/storage/logos/', $settings['white_logo']);
}

if (!empty($settings['black_logo']) && !str_contains($settings['black_logo'], '/storage/')) {
    $settings['black_logo'] = str_replace('/logos/', '/storage/logos/', $settings['black_logo']);
}
                }
                
                return $settings;
            }
            
            Log::warning('Failed to fetch system settings', [
                'status' => $response->status(),
                'url' => config('api.base_url') . '/system-setting'
            ]);
            
            return null;
        });
        
    } catch (\Exception $e) {
        Log::error('System Settings API Error: ' . $e->getMessage());
        return null;
    }
}

    /**
     * Helper to merge settings with view data
     */
    protected function viewWithSettings(string $view, array $data = [])
    {
        $data['settings'] = $data['settings'] ?? $this->getSystemSettings();
        return view($view, $data);
    }

    // ... existing methods below ...

    public function home(ProductService $productService)
    {
        $homeResponse = Http::get(config('api.base_url') . '/home');
        $homeData = $homeResponse->json();

        $productData = $productService->getProducts();
        
        $teamResponse = Http::get(config('api.base_url') . '/our-team');
        $teamData = $teamResponse->json();

        $blogResponse = Http::get(config('api.base_url') . '/blogs');
        $blogData = $blogResponse->json();
    
        return $this->viewWithSettings('frontend.pages.index', [
            'sliders'    => $homeData['slider'] ?? [],
            // 'settings'   => $homeData['settings'] ?? $this->getSystemSettings(), // ✅ Fallback to our method
            'partners'   => $homeData['partner'] ?? [],
            'about'      => $homeData['about_us'] ?? [],
            'counters'   => $homeData['counters'] ?? [],
            'services'   => $homeData['service'] ? [$homeData['service']] : [],
            'products'   => $productData['products'],
            'categories' => $productData['categories'],
            'team'       => $teamData['our_leaders'] ?? [], 
            'blogs'      => $blogData['blogs'] ?? [],
            'blogCategories' => $blogData['blog_category'] ?? $blogData['categories'] ?? [],
        ]);
    }

    public function productDetails($slug)
    {
        $response = Http::get(config('api.base_url') . '/products');
        $data = $response->json();
        $products = $data['products'] ?? [];
        $categories = $data['product_category'] ?? [];

        $product = collect($products)->firstWhere('slug', $slug);

        if (isset($product['images']) && is_array($product['images'])) {
            $product['images'] = array_values(array_unique($product['images']));
        }

        $category = collect($categories)
            ->firstWhere('id', $product['category_id'] ?? null);

        // ✅ Add settings to product details view
        return $this->viewWithSettings('frontend.pages.product-details', [
            'product' => $product,
            'category' => $category
        ]);
    }

    public function products(ProductService $productService)
    {
        $productData = $productService->getProducts();
        
        // ✅ Add settings to products view
        return $this->viewWithSettings('frontend.pages.products', [
            'products'   => $productData['products'],
            'categories' => $productData['categories'],
        ]);
    }

    public function privacyPolicy()
    {
        try {
            $response = Http::timeout(10)->get(config('api.base_url') . '/privacy-policy');
            
            if ($response->successful()) {
                $data = $response->json();
                $privacyPolicy = $data['privacyPolicy'] ?? $data['privacy_policy'] ?? null;
                
                if (!$privacyPolicy) {
                    Log::warning('Privacy policy data missing in API response', ['response' => $data]);
                }
                
                // ✅ Use helper to include settings
                return $this->viewWithSettings('frontend.pages.privacy-policy', [
                    'privacyPolicy' => $privacyPolicy
                ]);
            }
            
            Log::error('Failed to fetch privacy policy', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return $this->viewWithSettings('frontend.pages.privacy-policy', ['privacyPolicy' => null]);
            
        } catch (\Exception $e) {
            Log::error('Privacy Policy API Error: ' . $e->getMessage());
            return $this->viewWithSettings('frontend.pages.privacy-policy', ['privacyPolicy' => null]);
        }
    }

    public function termsConditions()
    {
        try {
            $response = Http::timeout(10)->get(config('api.base_url') . '/terms-conditions');
            
            if ($response->successful()) {
                $data = $response->json();
                $termsConditions = $data['termsConditions'] ?? $data['terms_conditions'] ?? $data['privacy_policy'] ?? null;
                
                if (!$termsConditions) {
                    Log::warning('Terms & Conditions data missing in API response', ['response' => $data]);
                }
                
                return $this->viewWithSettings('frontend.pages.terms-and-conditions', [
                    'termsConditions' => $termsConditions
                ]);
            }
            
            Log::error('Failed to fetch terms & conditions', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return $this->viewWithSettings('frontend.pages.terms-and-conditions', ['termsConditions' => null]);
            
        } catch (\Exception $e) {
            Log::error('Terms & Conditions API Error: ' . $e->getMessage());
            return $this->viewWithSettings('frontend.pages.terms-and-conditions', ['termsConditions' => null]);
        }
    }

    public function Accessibility()
    {
        try {
            $response = Http::timeout(10)->get(config('api.base_url') . '/accessibility');
            
            if ($response->successful()) {
                $data = $response->json();
                $accessibility = $data['accessibility'] ?? null;
                
                if (!$accessibility) {
                    Log::warning('Accessibility data missing in API response', ['response' => $data]);
                }
                
                return $this->viewWithSettings('frontend.pages.legals.accessibility', [
                    'accessibility' => $accessibility
                ]);
            }
            
            return $this->viewWithSettings('frontend.pages.legals.accessibility', ['accessibility' => null]);
            
        } catch (\Exception $e) {
            Log::error('Accessibility API Error: ' . $e->getMessage());
            return $this->viewWithSettings('frontend.pages.legals.accessibility', ['accessibility' => null]);
        }
    }

    public function shippingPolicy()
    {
        try {
            $response = Http::timeout(10)->get(config('api.base_url') . '/shipping-policy');
            
            if ($response->successful()) {
                $data = $response->json();
                $shippingPolicy = $data['shippingPolicy'] ?? null;
                
                if (!$shippingPolicy) {
                    Log::warning('Shipping Policy data missing in API response', ['response' => $data]);
                }
                
                return $this->viewWithSettings('frontend.pages.legals.shipping-policy', [
                    'shippingPolicy' => $shippingPolicy
                ]);
            }
            
            return $this->viewWithSettings('frontend.pages.legals.shipping-policy', [
                'shippingPolicy' => null
            ]);
            
        } catch (\Exception $e) {
            Log::error('Shipping Policy API Error: ' . $e->getMessage());
            return $this->viewWithSettings('frontend.pages.legals.shipping-policy', [
                'shippingPolicy' => null
            ]);
        }
    }

    public function cancelPolicy()
    {
        try {
            $response = Http::timeout(10)->get(config('api.base_url') . '/cancel-policy');
            
            if ($response->successful()) {
                $data = $response->json();
                $cancelPolicy = $data['cancellationPolicy'] ?? null;
                
                if (!$cancelPolicy) {
                    Log::warning('Cancellation Policy data missing in API response', [
                        'response' => $data,
                        'available_keys' => array_keys($data)
                    ]);
                }
                
                return $this->viewWithSettings('frontend.pages.legals.cancel-policy', [
                    'cancelPolicy' => $cancelPolicy
                ]);
            }
            
            return $this->viewWithSettings('frontend.pages.legals.cancel-policy', [
                'cancelPolicy' => null
            ]);
            
        } catch (\Exception $e) {
            Log::error('Cancellation Policy API Error: ' . $e->getMessage());
            return $this->viewWithSettings('frontend.pages.legals.cancel-policy', [
                'cancelPolicy' => null
            ]);
        }
    }

    public function disclaimer()
    {
        try {
            $response = Http::timeout(10)->get(config('api.base_url') . '/disclaimer');
            
            if ($response->successful()) {
                $data = $response->json();
                $disclaimer = $data['disclaimer'] ?? null;
                
                if (!$disclaimer) {
                    Log::warning('Disclaimer data missing in API response', [
                        'response' => $data,
                        'available_keys' => array_keys($data)
                    ]);
                }
                
                return $this->viewWithSettings('frontend.pages.legals.disclaimer', [
                    'disclaimer' => $disclaimer
                ]);
            }
            
            return $this->viewWithSettings('frontend.pages.legals.disclaimer', [
                'disclaimer' => null
            ]);
            
        } catch (\Exception $e) {
            Log::error('Disclaimer API Error: ' . $e->getMessage());
            return $this->viewWithSettings('frontend.pages.legals.disclaimer', [
                'disclaimer' => null
            ]);
        }
    }

    public function grievanceRedressal()
    {
        try {
            $response = Http::timeout(10)->get(config('api.base_url') . '/grievance-redressal');
            
            if ($response->successful()) {
                $data = $response->json();
                $grievanceRedressal = $data['grievanceRedressal'] ?? null;
                
                if (!$grievanceRedressal) {
                    Log::warning('Grievance Redressal data missing in API response', [
                        'response' => $data,
                        'available_keys' => array_keys($data)
                    ]);
                }
                
                return $this->viewWithSettings('frontend.pages.legals.grievance-redressal', [
                    'grievanceRedressal' => $grievanceRedressal
                ]);
            }
            
            return $this->viewWithSettings('frontend.pages.legals.grievance-redressal', [
                'grievanceRedressal' => null
            ]);
            
        } catch (\Exception $e) {
            Log::error('Grievance Redressal API Error: ' . $e->getMessage());
            return $this->viewWithSettings('frontend.pages.legals.grievance-redressal', [
                'grievanceRedressal' => null
            ]);
        }
    }
}