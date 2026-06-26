@extends('frontend.layout.master')

@section('content')
    {{-- SweetAlert for Success Message --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Success!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        timer: 2500,
                        showConfirmButton: false,
                        position: 'top-end',
                        toast: true
                    });
                }
            });
        </script>
    @endif

    <!--==============================
                    Breadcumb
                    ============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ url('assets/img/breadcrumb/breadcrumb.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Cart</h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Cart</li>
                </ul>
            </div>
        </div>
    </div>

    <!--==============================
                    Cart Area
                    ============================== -->
    <div class="space">
        <div class="vs-cart-wrapper">
            <div class="container">

                <form action="{{ route('cart.update') }}" method="POST" class="woocommerce-cart-form" id="cartForm">
                    @csrf
                    <table class="cart_table">
                        <thead>
                            <tr>
                                <th class="cart-col-image">Image</th>
                                <th class="cart-col-productname">Product Name</th>
                                <th class="cart-col-price">Price</th>
                                <th class="cart-col-quantity">Quantity</th>
                                <th class="cart-col-total">Total</th>
                                <th class="cart-col-remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody id="cartItemsBody">
                            @forelse($cart as $id => $item)
                                @php
                                    $qty = max(1, (int) ($item['quantity'] ?? 1));
                                    $price = (float) ($item['price'] ?? 0);
                                    $lineTotal = $price * $qty;
                                @endphp
                                <tr class="cart_item" data-id="{{ $id }}" data-price="{{ $price }}">
                                    <td data-title="Product">
                                        <a class="cart-productimage"
                                           href="{{ !empty($item['slug']) ? route('product-details', $item['slug']) : '#' }}">
                                            <img width="100" height="95"
                                                 src="{{ str_starts_with($item['image'] ?? '', 'http') ? $item['image'] : env('BACKEND_URL', '') . '/storage/' . ($item['image'] ?? '') }}"
                                                 alt="{{ $item['name'] }}">
                                        </a>
                                    </td>
                                    <td data-title="Name">
                                        <a class="cart-productname"
                                           href="{{ !empty($item['slug']) ? route('product-details', $item['slug']) : '#' }}">
                                            {{ $item['name'] }}
                                        </a>
                                    </td>
                                    <td data-title="Price">
                                        <span class="amount item-price">
                                            @if(!empty($item['original_price']) && $item['original_price'] > $item['price'])
                                                <del class="text-muted small me-1">
                                                    Rs.{{ number_format($item['original_price'], 2) }}
                                                </del>
                                                <bdi>
                                                    <span class="text-danger">Rs.</span>
                                                    {{ number_format($item['price'], 2) }}
                                                </bdi>
                                                @if(!empty($item['discount_percentage']))
                                                    <span class="badge bg-danger ms-1">
                                                        -{{ $item['discount_percentage'] }}%
                                                    </span>
                                                @endif
                                            @else
                                                <bdi><span>Rs.</span>{{ number_format($item['price'], 2) }}</bdi>
                                            @endif
                                        </span>
                                    </td>
                                    <td data-title="Quantity">
                                        <div class="quantity style2">
                                            <div class="quantity__field quantity-container">
                                                <div class="quantity__buttons">
                                                    <button type="button" class="quantity-plus qty-btn" data-id="{{ $id }}">
                                                        <i class="fal fa-plus"></i>
                                                    </button>
                                                    <input type="number" class="qty-input" step="1" min="1" max="100"
                                                           name="quantity[{{ $id }}]"
                                                           value="{{ max(1, (int) ($item['quantity'] ?? 1)) }}"
                                                           title="Qty" data-id="{{ $id }}"
                                                           oninput="this.value = Math.max(1, parseInt(this.value) || 1)">
                                                    <button type="button" class="quantity-minus qty-btn" data-id="{{ $id }}">
                                                        <i class="fal fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-title="Total">
                                        <span class="amount item-total">
                                            <bdi><span>Rs.</span><span
                                                    class="total-value">{{ number_format($lineTotal, 2) }}</span></bdi>
                                        </span>
                                    </td>
                                    <td data-title="Remove">
                                        <a href="javascript:void(0)" class="remove remove-cart"
                                           data-id="{{ $id }}" data-name="{{ $item['name'] }}"
                                           style="cursor: pointer;">
                                            <i class="fal fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-cart">
                                            <img src="{{ asset('assets/img/cart/bag.png') }}" alt="Empty Cart"
                                                style="max-width: 200px;">
                                            <h4 class="mt-3">Your cart is empty</h4>
                                            <a href="{{ route('products') }}" class="vs-btn mt-3">Continue Shopping</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if (count($cart) > 0)
                        <div class="row align-items-center g-3 mt-3">
                            <!-- Coupon Input -->
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Enter Coupon Code">
                            </div>
                            <!-- Apply Button -->
                            <div class="col-md-2">
                                <button type="button" class="vs-btn w-100" onclick="alert('Coupon feature coming soon!')">
                                    Apply
                                </button>
                            </div>
                            <!-- Update Cart -->
                            <div class="col-md-3">
                                <button type="submit" class="vs-btn w-100" id="updateCartBtn">
                                    Update Cart
                                </button>
                            </div>
                            <!-- Continue Shopping -->
                            <div class="col-md-3">
                                <a href="{{ route('products') }}" class="vs-btn w-100 text-center">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    @endif
                </form>

                <!-- Cart Totals -->
                @if (count($cart) > 0)
                    <div class="row justify-content-end mt-5">
                        <div class="col-md-8 col-lg-7 col-xl-6">
                            <h2 class="h4 summary-title">Cart Totals</h2>
                            <table class="cart_totals">
                                <tbody>
                                    <tr>
                                        <td>Cart Subtotal</td>
                                        <td data-title="Cart Subtotal">
                                            <span class="amount" id="cartSubtotal">
                                                <bdi><span>Rs.</span><span
                                                        id="subtotalValue">{{ number_format($total, 2) }}</span></bdi>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="shipping">
                                        <th>Shipping and Handling</th>
                                        <td data-title="Shipping and Handling">
                                            <ul class="woocommerce-shipping-methods list-unstyled">
                                                <li>
                                                    <input type="radio" id="free_shipping" name="shipping_method"
                                                           class="shipping_method" value="0">
                                                    <label for="free_shipping">Free shipping</label>
                                                </li>
                                                <li>
                                                    <input type="radio" id="flat_rate" name="shipping_method"
                                                           class="shipping_method" value="50" checked>
                                                    <label for="flat_rate">Flat rate (Rs. 50)</label>
                                                </li>
                                            </ul>
                                            <p class="woocommerce-shipping-destination">
                                                Shipping options will be updated during checkout.
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="order-total">
                                        <td>Order Total</td>
                                        <td data-title="Total">
                                            <strong>
                                                <span class="amount">
                                                    <bdi><span>Rs.</span><span
                                                            id="orderTotalValue">{{ number_format($total + 50, 2) }}</span></bdi>
                                                </span>
                                            </strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="wc-proceed-to-checkout mb-0">
                                <a href="{{ route('checkout') }}" class="vs-btn">Proceed to checkout</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
