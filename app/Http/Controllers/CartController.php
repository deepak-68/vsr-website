<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // CartController.php

  public function addToCart(Request $request)
{
    $productId = (int) $request->input('product_id');
    
    // ✅ Get quantity from request (default 1)
    $quantity = max(1, (int) $request->input('quantity', 1));
    
    // ✅ Get prices
    $discountedPrice = (float) $request->input('product_price');
    $originalPrice = (float) $request->input('original_price', $discountedPrice);
    
    // Security check
    if ($discountedPrice > $originalPrice) {
        $discountedPrice = $originalPrice;
    }
    $finalPrice = $discountedPrice > 0 ? $discountedPrice : $originalPrice;
    
    $cart = Session::get('cart', []);

    if (isset($cart[$productId])) {
        // ✅ Item exists - ADD quantity (not replace)
        $cart[$productId]['quantity'] += $quantity;
        $cart[$productId]['price'] = $finalPrice; // Refresh price
    } else {
        // ✅ New item - store with selected quantity
        $cart[$productId] = [
            'product_id'         => $productId,
            'name'               => $request->input('product_name'),
            'slug'               => $request->input('product_slug', 'product-' . $productId),
            'price'              => $finalPrice,
            'original_price'     => $originalPrice,
            'image'              => $request->input('product_image'),
            'quantity'           => $quantity,  // ✅ Selected quantity from product page
            'discount_percentage'=> $request->input('discount_percentage', 0),
        ];
    }

    Session::put('cart', $cart);
    Session::save();
    
    $cartCount = $this->getCartCount();
    $subtotal = $this->calculateCartTotal($cart);

    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart_count' => $cartCount,
            'cart_items' => $this->getCartItemsHTML(),
            'subtotal' => number_format($subtotal, 2),
            'item_quantity' => $cart[$productId]['quantity'] // ✅ Return added quantity
        ]);
    }

    return redirect()->route('cart')->with('success', 'Product added to cart!');
}

    public function removeFromCart(Request $request)
    {
        try {
            $productId = $request->input('product_id');

            if (!$productId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid product ID'
                ], 400);
            }

            $cart = Session::get('cart', []);

            if (!isset($cart[$productId])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart'
                ], 404);
            }

            unset($cart[$productId]);
            Session::put('cart', $cart);
            Session::save();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed successfully',
                    'cart_count' => $this->getCartCount(),
                    'cart_items' => $this->getCartItemsHTML(),      // For sidebar
                    'cart_page_rows' => $this->getCartPageRowsHTML(), // For main cart page (if open)
                    'subtotal' => number_format($this->calculateCartTotal(), 2)
                ]);
            }
            // Return JSON response
            return redirect()->back()->with('success', 'Item removed from cart!');
        } catch (\Exception $e) {
            Log::error('Remove from cart error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
    // Cart Page Display
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = $this->calculateCartTotal($cart);
        return view('frontend.pages.cart', compact('cart', 'total'));
    }

    // Helper: Calculate Total
    private function calculateCartTotal($cart = null)
    {
        $cart = $cart ?? Session::get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $price = (float) ($item['price'] ?? 0);
            $quantity = max(1, (int) ($item['quantity'] ?? 1));
            $total += $price * $quantity;
        }

        return $total;
    }

    // ✅ Helper: Get Cart Count
    private function getCartCount()
    {
        $cart = Session::get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }
    private function getCartResponseData()
    {
        $cart = Session::get('cart', []);

        return [
            'cart_count' => $this->getCartCount(),
            'subtotal' => number_format($this->calculateCartTotal(), 2),
            'cart_items_html' => $this->getCartItemsHTML(), // For sidebar
            'cart_page_html' => $this->getCartPageRowsHTML() // For main cart page (optional)
        ];
    }
    // ✅ Helper: Generate Cart Items HTML (for side cart)
    private function getCartItemsHTML()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return '<li class="text-center py-3 text-muted"><i class="fal fa-shopping-basket fa-2x mb-2 d-block"></i>Your cart is empty</li>';
        }

        $html = '';
        foreach ($cart as $id => $item) {
            $imageUrl = $item['image'] ?? '';
            if (!str_starts_with($imageUrl, 'http') && !empty($imageUrl)) {
                $imageUrl = env('BACKEND_URL', '') . '/storage/' . $imageUrl;
            }

            $productUrl = !empty($item['slug']) ? route('product-details', $item['slug']) : '#';
            $name = htmlspecialchars($item['name'] ?? $item['product_name'] ?? 'Product');
            $qty = (int) ($item['quantity'] ?? 1);
            $price = number_format((float) ($item['price'] ?? 0), 2);

            $html .= '<li class="mini_cart_item" data-id="' . $id . '">';
            $html .= '<a href="#" class="remove remove-cart" data-id="' . $id . '"><i class="fal fa-trash-alt"></i></a>';
            $html .= '<a href="' . $productUrl . '">';
            $html .= '<img src="' . htmlspecialchars($imageUrl ?: asset('assets/img/product/product-1-1.png')) . '" alt="' . $name . '">';
            $html .= htmlspecialchars(\Illuminate\Support\Str::limit($name, 30)) . '</a>';
            $html .= '<span class="quantity">' . $qty . ' × <span class="amount"><span>Rs.</span>' . $price . '</span></span>';
            $html .= '</li>';
        }
        return $html;
    }
    // Remove Item from Cart
    // Helper: Generate table rows for main cart page (if needed via AJAX)
    private function getCartPageRowsHTML()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return '<tr><td colspan="6" class="text-center py-5">Your cart is empty</td></tr>';
        }

        $html = '';
        foreach ($cart as $id => $item) {
            $price = (float) ($item['price'] ?? 0);
            $qty = max(1, (int) ($item['quantity'] ?? 1));
            $lineTotal = $price * $qty;
            $imageUrl = $item['image'] ?? '';
            if (!str_starts_with($imageUrl, 'http') && !empty($imageUrl)) {
                $imageUrl = env('BACKEND_URL', '') . '/storage/' . $imageUrl;
            }
            $productUrl = !empty($item['slug']) ? route('product-details', $item['slug']) : '#';
            $name = htmlspecialchars($item['name'] ?? 'Product');

            $html .= '<tr class="cart_item" data-id="' . $id . '" data-price="' . $price . '">';
            $html .= '<td><a class="cart-productimage" href="' . $productUrl . '"><img width="100" height="95" src="' . htmlspecialchars($imageUrl ?: asset('assets/img/product/product-1-1.png')) . '" alt="' . $name . '"></a></td>';
            $html .= '<td><a class="cart-productname" href="' . $productUrl . '">' . $name . '</a></td>';
            $html .= '<td><span class="amount item-price"><bdi><span>Rs.</span>' . number_format($price, 2) . '</bdi></span></td>';
            $html .= '<td><input type="number" class="qty-input" name="quantity[' . $id . ']" value="' . $qty . '" min="1" max="100"></td>';
            $html .= '<td><span class="amount item-total"><bdi><span>Rs.</span><span class="total-value">' . number_format($lineTotal, 2) . '</span></bdi></span></td>';
            $html .= '<td><a href="#" class="remove remove-cart" data-id="' . $id . '" data-name="' . $name . '"><i class="fal fa-trash-alt"></i></a></td>';
            $html .= '</tr>';
        }
        return $html;
    }
    // Update Cart Quantities
    public function updateCart(Request $request)
    {
        $quantities = $request->input('quantity', []);
        $cart = Session::get('cart', []);

        foreach ($quantities as $productId => $qty) {
            $qty = (int) $qty;

            if (isset($cart[$productId])) {
                if ($qty > 0) {
                    $cart[$productId]['quantity'] = $qty;
                } else {
                    // Remove item if quantity is 0 or less
                    unset($cart[$productId]);
                }
            }
        }

        Session::put('cart', $cart);
        Session::save();

        // Return JSON for AJAX requests (if ever needed)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_count' => $this->getCartCount(),
                'cart_items' => $this->getCartItemsHTML(),
                'subtotal' => number_format($this->calculateCartTotal(), 2)
            ]);
        }

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }
}
