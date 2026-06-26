<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class WishlistController extends Controller
{
    public function index()
{
    // Get wishlist from session
    $wishlistItems = session()->get('wishlist', []);
    
    // Get cart items for comparison
    $cartItems = session()->get('cart', []);
    $cartProductIds = array_keys($cartItems); // Get IDs of products already in cart
    
    // Fetch fresh product data from API
    $wishlistProducts = [];
    if (!empty($wishlistItems)) {
        try {
            $response = Http::timeout(10)->get(config('api.base_url') . '/products');
            if ($response->successful()) {
                $allProducts = $response->json()['products'] ?? $response->json()['data'] ?? [];
                
                // Filter products that are in wishlist
                $wishlistProducts = collect($allProducts)
                    ->filter(fn($p) => in_array($p['id'], $wishlistItems))
                    ->values()
                    ->toArray();
            }
        } catch (\Exception $e) {
            Log::warning('API fetch failed: ' . $e->getMessage());
        }
    }

    return view('frontend.pages.wishlist', [
        'products' => $wishlistProducts,
        'cart_product_ids' => $cartProductIds  // ✅ Pass cart IDs to view
    ]);
}

    public function add(Request $request)
    {
        $productId = $request->product_id;
        $wishlist = session()->get('wishlist', []);

        if (!in_array($productId, $wishlist)) {
            $wishlist[] = $productId;
            session()->put('wishlist', $wishlist);
            
            return response()->json([
                'success' => true,
                'message' => 'Added to wishlist'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Already in wishlist'
        ]);
    }

   public function remove(Request $request)
{
    try {
        $productId = $request->input('product_id');
        
        if (!$productId) {
            return response()->json(['success' => false, 'message' => 'Invalid product ID'], 400);
        }
        
        $wishlist = session()->get('wishlist', []);
        
        if (($key = array_search($productId, $wishlist)) !== false) {
            unset($wishlist[$key]);
            $wishlist = array_values($wishlist);
            session()->put('wishlist', $wishlist);
            session()->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Removed from wishlist',
            'wishlist_count' => count($wishlist)  // ✅ Return count
        ]);
        
    } catch (\Exception $e) {
        Log::error('Wishlist remove error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Server error'], 500);
    }
}

   // app/Http/Controllers/WishlistController.php

public function toggle(Request $request)
{
    try {
        $productId = $request->input('product_id');
        
        if (!$productId) {
            return response()->json(['success' => false, 'message' => 'Invalid product ID'], 400);
        }
        
        $wishlist = session()->get('wishlist', []);
        $inWishlist = in_array($productId, $wishlist);
        
        if ($inWishlist) {
            $wishlist = array_filter($wishlist, fn($id) => $id != $productId);
            $message = 'Product removed from wishlist';
        } else {
            $wishlist[] = $productId;
            $message = 'Product added to wishlist';
        }
        
        session()->put('wishlist', array_values($wishlist));
        session()->save();
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'in_wishlist' => !$inWishlist,
            'wishlist_count' => count($wishlist)  // ✅ Return count for badge
        ]);
        
    } catch (\Exception $e) {
        Log::error('Wishlist toggle error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Server error'], 500);
    }
}
}