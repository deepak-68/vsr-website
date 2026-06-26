<!--==============================
    Product Area
    ============================== -->
<section class="product-layout2 space">
    <div class="container">
        <div class="title-area text-center wow fadeInUp wow-animated" data-wow-delay="0.3s">
            <div class="title-img">
                <img src="assets/img/icon/title-logo.png" alt="title logo">
            </div>
            <span class="sec-subtitle">Our Products</span>
            <h2 class="sec-title">Organic Products</h2>
        </div>
        <div class="row vs-carousel z-index-common" data-slide-show="4" data-lg-slide-show="3" data-md-slide-show="2"
            data-autoplay="true" data-arrows="false" data-dots="true" data-center-mode="true">
            @forelse($products as $product)
                <div class="col-lg-3">
                    <div class="product-style2">
                        <div class="product-img">
                            @php
                                $image = $product['images'][0] ?? null;
                            @endphp

                            <img src="{{ $image ? env('BACKEND_URL') . '/storage/' . $image : asset('assets/img/product/product-1-1.png') }}"
                                alt="product">
                        </div>

                        <div class="product-about">
                            <p class="text">{{ $product['size'] ?? 'Size' }}</p>

                            <h2 class="product-title">
                                <a href="{{ route('product-details', $product['slug']) }}">
                                    {{ $product['name'] ?? 'Product' }}
                                </a>
                            </h2>

                            <span class="price">
                                <del>Rs.{{ $product['price'] ?? '0' }}</del>
                                Rs.{{ $product['discount_price'] ?? '0' }}
                            </span>
                        </div>
                        <div class="social-style">
                            <ul>
                                <li>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                        <input type="hidden" name="product_name" value="{{ $product['name'] }}">

                                        {{-- ✅ Send discounted price as product_price --}}
                                        <input type="hidden" name="product_price"
                                            value="{{ $product['discount_price'] ?? $product['price'] }}">

                                        {{-- ✅ Send original price for strikethrough display --}}
                                        <input type="hidden" name="original_price" value="{{ $product['price'] }}">

                                        {{-- ✅ Send discount percentage for badge --}}
                                        <input type="hidden" name="discount_percentage"
                                            value="{{ $product['discount_percentage'] ?? 0 }}">

                                        <input type="hidden" name="product_slug" value="{{ $product['slug'] }}">
                                        <input type="hidden" name="product_image"
                                            value="{{ $product['images'][0] ?? '' }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="vs-btn">
                                            <i class="far fa-shopping-basket"></i> Add to Cart
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <button
                                        class="icon-btn wishlist-toggle {{ in_array($product['id'], session('wishlist', [])) ? 'active' : '' }}"
                                        data-product-id="{{ $product['id'] }}">
                                        <i
                                            class="{{ in_array($product['id'], session('wishlist', [])) ? 'fas' : 'far' }} fa-heart"></i>
                                    </button>
                                </li>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No Products Found</p>
                </div>
            @endforelse
        </div>
    </div>
    <div class="shape-mockup moving z-index d-none d-lg-block" style="left: 2%; bottom: 22%;"><img
            src="assets/img/shep/product-shep-2.png" alt="shapes"></div>
    <div class="shape-mockup moving z-index d-none d-lg-block" style="right: 2%; bottom: 22%;"><img
            src="assets/img/shep/product-shep-1.png" alt="shapes"></div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Use class selector instead of ID
            const forms = document.querySelectorAll('.addToCartForm');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('.add-to-cart-btn');
                    const originalText = submitBtn.innerHTML;

                    // Show loading state
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                    submitBtn.disabled = true;

                    fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Update side cart
                                const cartList = document.querySelector(
                                    '.widget_shopping_cart_content ul.cart_list');
                                if (cartList) {
                                    cartList.innerHTML = data.cart_items;
                                }

                                // Update cart count if you have a badge
                                const cartBadge = document.querySelector('.cart-count-badge');
                                if (cartBadge) {
                                    cartBadge.textContent = data.cart_count;
                                }

                                // Show success message (you can customize this)
                                showNotification('Success', data.message ||
                                    'Product added to cart!', 'success');

                                // Reset button
                                submitBtn.innerHTML = originalText;
                                submitBtn.disabled = false;
                            } else {
                                throw new Error(data.message || 'Failed to add to cart');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Error', error.message ||
                                'Failed to add product to cart', 'error');

                            // Reset button
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        });
                });
            });

            // Notification function
            function showNotification(title, message, type = 'success') {
                // You can use a toast library or create a simple alert
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: title,
                        text: message,
                        icon: type,
                        timer: 2000,
                        showConfirmButton: false,
                        position: 'top-end',
                        toast: true
                    });
                } else {
                    alert(message);
                }
            }
        });
    </script>
@endpush
