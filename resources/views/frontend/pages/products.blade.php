@extends('frontend.layout.master')
@section('content')
    <!--==============================
        Breadcumb
        ============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ url('assets/img/breadcrumb/breadcrumb.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Our Products</h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Our Products</li>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
        Products area
        ============================== -->
    <section class="products space">
        <div class="container">
            <div class="vs-sort-bar">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-auto">
                        <div class="col-auto">
                            <p class="woocommerce-result-count">Showing 1–12 of 13 results</p>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <div class="row justify-content-center">
                            <div class="col-sm-auto">
                                <form class="woocommerce-ordering" method="get">
                                    <select name="orderby" class="orderby" aria-label="Shop order">
                                        <option value="menu_order" selected="selected">Default Sorting</option>
                                        <option value="popularity">Sort by popularity</option>
                                        <option value="rating">Sort by average rating</option>
                                        <option value="date">Sort by latest</option>
                                        <option value="price">Sort by price: low to high</option>
                                        <option value="price-desc">Sort by price: high to low</option>
                                    </select>
                                </form>
                            </div>
                            <div class="col-auto">
                                <div class="nav" role="tablist">
                                    <a href="#" class="icon-btn" id="tab-shop-list" data-bs-toggle="tab"
                                        data-bs-target="#tab-list" role="tab" aria-controls="tab-grid"
                                        aria-selected="false"><i class="fas fa-list"></i></a>
                                    <a href="#" class="icon-btn active" id="tab-shop-grid" data-bs-toggle="tab"
                                        data-bs-target="#tab-grid" role="tab" aria-controls="tab-grid"
                                        aria-selected="true"><i class="fas fa-th"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
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
            <div class="vs-pagination text-center mb-0 mt-4">
                <ul>
                    <li class="arrow"><a href="#"><i class="fal fa-long-arrow-left"></i></a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">...</a></li>
                    <li><a href="#">6</a></li>
                    <li class="arrow"><a href="#"><i class="fal fa-long-arrow-right"></i></a></li>
                </ul>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        // Wishlist toggle
        document.querySelectorAll('.wishlist-toggle').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.dataset.productId;
                const icon = this.querySelector('i');

                fetch("{{ route('wishlist.toggle') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.in_wishlist) {
                                icon.classList.remove('far');
                                icon.classList.add('fas');
                                this.classList.add('active');
                            } else {
                                icon.classList.remove('fas');
                                icon.classList.add('far');
                                this.classList.remove('active');
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endpush
