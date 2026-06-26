    <div class="sideCart-wrapper offcanvas-wrapper d-none d-lg-block">
        <div class="sidemenu-content">
            <button class="closeButton border-theme bg-theme-hover sideMenuCls2">
                <i class="far fa-times"></i>
            </button>
            <div class="widget widget_shopping_cart">
                <h3 class="widget_title">Shopping cart</h3>
                <div class="widget_shopping_cart_content">

                    {{-- ✅ Dynamic Cart Items Loop --}}
                    @php
                        $cart = session('cart', []);
                        $cartTotal = 0;
                    @endphp

                    <ul class="cart_list" id="sideCartList">
                        @forelse($cart as $id => $item)
                            @php
                                $itemTotal = (float) $item['price'] * (int) $item['quantity'];
                                $cartTotal += $itemTotal;
                                $imageUrl = $item['image'] ?? '';
                                if (!str_starts_with($imageUrl, 'http') && !empty($imageUrl)) {
                                    $imageUrl = env('BACKEND_URL', '') . '/storage/' . $imageUrl;
                                }
                            @endphp
                            <li class="mini_cart_item" data-id="{{ $id }}">
                                <a href="#" class="remove remove-cart" data-id="{{ $id }}">
                                    <i class="fal fa-trash-alt"></i>
                                </a>
                                <a href="{{ !empty($item['slug']) ? route('product-details', $item['slug']) : '#' }}">
                                    <img src="{{ $imageUrl ?: asset('assets/img/product/product-1-1.png') }}"
                                        alt="{{ $item['name'] }}">
                                    {{ Str::limit($item['name'], 30) }}
                                </a>
                                <span class="quantity">
                                    {{ $item['quantity'] }} ×
                                    <span class="amount">
                                        <span>Rs.</span>{{ number_format($item['price'], 2) }}
                                    </span>
                                </span>
                            </li>
                        @empty
                            <li class="text-center py-3 text-muted">
                                <i class="fal fa-shopping-basket fa-2x mb-2 d-block"></i>
                                Your cart is empty
                            </li>
                        @endforelse
                    </ul>

                    <div class="total">
                        <strong>Subtotal:</strong>
                        <span class="amount" id="sideCartSubtotal">
                            <span>Rs.</span>{{ number_format($cartTotal, 2) }}
                        </span>
                    </div>
                    <div class="buttons">
                        <a href="{{ route('cart') }}" class="vs-btn">View cart</a>
                        <a href="{{ route('checkout') }}" class="vs-btn">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
