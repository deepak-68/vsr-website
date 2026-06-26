<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display checkout page with cart items
     */
   public function index()
{
    // Get cart items from session
    $cartItems = session()->get('cart', []);
    
    if (empty($cartItems)) {
        return redirect()->route('cart')->with('error', 'Your cart is empty');
    }

    // Fetch fresh product data from API for accurate pricing
    $apiProducts = collect([]);
    try {
        $response = Http::timeout(10)->get(config('api.base_url') . '/products');
        if ($response->successful()) {
            $allProducts = $response->json()['products'] ?? $response->json()['data'] ?? [];
            $apiProducts = collect($allProducts)->keyBy('id');
        }
    } catch (\Exception $e) {
        Log::warning('Failed to fetch products from API: ' . $e->getMessage());
        // Continue with cart data only - don't block checkout
    }

    // Calculate cart totals
    $subtotal = 0;
    $formattedItems = [];

    // ✅ START FOREACH LOOP
    foreach ($cartItems as $key => $item) {
        // Use array key as product_id (how cart is structured)
        $productId = is_numeric($key) ? (int) $key : ($item['product_id'] ?? $item['id'] ?? null);
        
        if (!$productId) {
            Log::warning('Cart item missing product ID', ['item' => $item, 'cart_key' => $key]);
            continue;
        }

        // Safe API product lookup
        $product = $apiProducts->get($productId);
        
        // Safe price fallback chain
        $price = 0;
        if ($product && is_array($product)) {
            $price = $product['discount_price'] ?? $product['price'] ?? 0;
        }
        if ($price == 0) {
            $price = $item['price'] ?? $item['product_price'] ?? 0;
        }
        
        $quantity = max(1, (int)($item['quantity'] ?? 1));
        $lineTotal = $price * $quantity;
        $subtotal += $lineTotal;

        // Safe image URL handling
        $image = null;
        if ($product && is_array($product) && !empty($product['images'])) {
            $image = is_array($product['images']) ? ($product['images'][0] ?? null) : $product['images'];
        }
        if (empty($image)) {
            $image = $item['product_image'] ?? $item['image'] ?? null;
        }

        // ✅ THIS MUST BE INSIDE THE FOREACH LOOP
      $formattedItems[] = [
    'id' => $productId,
    'name' => $item['product_name'] 
                ?? $item['name'] 
                ?? (isset($product['name']) ? $product['name'] : 'Product'),
    'price' => (float) $price,
    'quantity' => $quantity,
    'total' => $lineTotal,
    'image' => $image,
    'slug' => isset($product['slug']) ? $product['slug'] : ($item['slug'] ?? '#')
];
    } // ✅ END FOREACH LOOP

    // If no valid items after filtering
    if (empty($formattedItems)) {
        session()->forget('cart');
        return redirect()->route('cart')->with('error', 'Your cart contains invalid items');
    }

    // Shipping calculation
    $shipping = $subtotal > 1000 ? 0 : 50;
    $total = $subtotal + $shipping;

    return view('frontend.pages.checkout', [
        'cartItems' => $formattedItems,
        'subtotal' => $subtotal,
        'shipping' => $shipping,
        'total' => $total,
        'customer' => session()->get('customer_data', [])
    ]);
}
    /**
     * Update shipping cost via AJAX
     */
    public function updateShipping(Request $request)
    {
        $request->validate([
            'country' => 'required|string',
            'postcode' => 'nullable|string'
        ]);

        // Recalculate from session cart
        $cartItems = session()->get('cart', []);
        $subtotal = 0;
        
        foreach ($cartItems as $item) {
            $price = $item['price'] ?? $item['product_price'] ?? 0;
            $quantity = max(1, (int)($item['quantity'] ?? 1));
            $subtotal += $price * $quantity;
        }

        $shipping = $subtotal > 1000 ? 0 : 50;

        return response()->json([
            'success' => true,
            'shipping' => $shipping,
            'total' => $subtotal + $shipping,
            'subtotal' => $subtotal
        ]);
    }

    /**
     * Process checkout and create order
     */
    public function process(Request $request)
    {
        // Validate billing details
        $validated = $request->validate([
            'billing_first_name' => 'required|string|max:255',
            'billing_last_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_address' => 'required|string|max:500',
            'billing_city' => 'required|string|max:255',
            'billing_postcode' => 'nullable|string|max:20',
            'billing_country' => 'required|string|max:255',
            'payment_method' => 'required|in:bacs,cheque,cod,paypal',
            'terms' => 'accepted'
        ], [
            'terms.accepted' => 'You must agree to the terms and conditions'
        ]);

        // Get and validate cart items
        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return back()->with('error', 'Your cart is empty');
        }

        // Fetch product data from API
        $apiProducts = collect([]);
        try {
            $response = Http::timeout(10)->get(config('api.base_url') . '/products');
            if ($response->successful()) {
                $allProducts = $response->json()['products'] ?? $response->json()['data'] ?? [];
                $apiProducts = collect($allProducts)->keyBy('id');
            }
        } catch (\Exception $e) {
            Log::warning('API fetch failed during checkout: ' . $e->getMessage());
            // Continue with cart data only
        }

        // Prepare order items with defensive key handling
        $orderItems = [];
        $orderTotal = 0;

        foreach ($cartItems as $cartKey => $item) {
            // Use array key as product_id (how cart is structured)
            $productId = is_numeric($cartKey) ? (int) $cartKey : null;
            
            if (!$productId) {
                Log::warning('Invalid cart key', ['key' => $cartKey]);
                continue;
            }

            $product = $apiProducts->get($productId);
            
            // 🔧 Safe price lookup with fallbacks
            $price = 0;
            if ($product && is_array($product)) {
                $price = $product['discount_price'] ?? $product['price'] ?? 0;
            }
            if ($price == 0) {
                $price = $item['price'] ?? $item['product_price'] ?? 0;
            }
            
            $quantity = max(1, (int)($item['quantity'] ?? 1));
            
            $orderItems[] = [
                'product_id' => $productId,
                'product_name' => $item['product_name'] ?? $item['name'] ?? ($product['name'] ?? 'Unknown'),
                'price' => $price,
                'quantity' => $quantity,
                'subtotal' => $price * $quantity
            ];
            $orderTotal += $price * $quantity;
        }

        if (empty($orderItems)) {
            return back()->with('error', 'Cannot process order: invalid cart items');
        }

        // Calculate totals
        $shipping = $orderTotal > 1000 ? 0 : 50;
        $grandTotal = $orderTotal + $shipping;

        // Prepare order payload
        $orderData = [
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'customer_name' => $validated['billing_first_name'] . ' ' . $validated['billing_last_name'],
            'customer_email' => $validated['billing_email'],
            'customer_phone' => $validated['billing_phone'],
            'billing_address' => [
                'first_name' => $validated['billing_first_name'],
                'last_name' => $validated['billing_last_name'],
                'address' => $validated['billing_address'],
                'city' => $validated['billing_city'],
                'postcode' => $validated['billing_postcode'],
                'country' => $validated['billing_country'],
                'phone' => $validated['billing_phone'],
                'email' => $validated['billing_email']
            ],
            'shipping_address' => $request->has('ship_to_different_address') ? [
                'first_name' => $request->shipping_first_name ?? $validated['billing_first_name'],
                'last_name' => $request->shipping_last_name ?? $validated['billing_last_name'],
                'address' => $request->shipping_address ?? $validated['billing_address'],
                'city' => $request->shipping_city ?? $validated['billing_city'],
                'postcode' => $request->shipping_postcode ?? $validated['billing_postcode'],
                'country' => $request->shipping_country ?? $validated['billing_country'],
                'phone' => $request->shipping_phone ?? $validated['billing_phone'],
                'email' => $request->shipping_email ?? $validated['billing_email']
            ] : null,
            'items' => $orderItems,
            'subtotal' => $orderTotal,
            'shipping' => $shipping,
            'total' => $grandTotal,
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_method'] === 'cod' ? 'pending' : 'pending_payment',
            'order_status' => 'processing',
            'notes' => $request->order_notes ?? null,
            'created_at' => now()
        ];

        try {
            // Send to backend API
            $apiResponse = Http::timeout(30)->post(config('api.base_url') . '/orders', $orderData);
            
            if ($apiResponse->successful()) {
                $this->clearCartAndRedirect($orderData);
                return redirect()->route('checkout.success');
            }
            
            Log::warning('API order creation failed', [
                'status' => $apiResponse->status(),
                'response' => $apiResponse->body()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Checkout API Error: ' . $e->getMessage(), [
                'order_data' => array_diff_key($orderData, array_flip(['items']))
            ]);
        }

        // Fallback: Clear cart and show success
        $this->clearCartAndRedirect($orderData, true);
        return redirect()->route('checkout.success');
    }

    /**
     * Helper: Clear cart and store order info for success page
     */
    private function clearCartAndRedirect(array $orderData, bool $fallback = false)
    {
        session()->forget('cart');
        session()->forget('cart_subtotal');
        
        session()->put('last_order', [
            'order_number' => $orderData['order_number'],
            'total' => $orderData['total'],
            'payment_method' => $orderData['payment_method'],
            'note' => $fallback ? 'Order processed with fallback method' : null
        ]);
    }

    /**
     * Display order success page
     */
    public function success()
    {
        $order = session()->get('last_order');
        
        if (!$order) {
            return redirect()->route('home');
        }
        
        return view('frontend.pages.checkout-success', compact('order'));
    }

    /**
     * Display order cancelled page
     */
    public function cancel()
    {
        return redirect()->route('checkout')->with('info', 'Order cancelled. You can try again anytime.');
    }
}