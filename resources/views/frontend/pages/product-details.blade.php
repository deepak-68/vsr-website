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
                    Products-details area
                    ============================== -->
    <div class="vs-product-wrapper product-details space-top space-extra-bottom">
        <div class="container">
            @if ($product)
                <div class="row g-5">

                    <div class="col-lg-6">
                        <div class="product-slide-row row">
                            <div class="col-lg-2 col-md-3">
                                <div class="product-thumb-slide vs-carousel" data-slide-show="6" data-md-slide-show="3"
                                    data-sm-slide-show="3" data-xs-slide-show="3" data-asnavfor=".product-big-img"
                                    data-vertical="true" data-md-vertical="true" data-sm-vertical="false">
                                    @php
                                        $product['images'] = isset($product['images'])
                                            ? array_values(array_unique($product['images']))
                                            : [];
                                    @endphp
                                    @forelse($product['images'] ?? [] as $img)
                                        <div>
                                            <div class="thumb">
                                                <img src="{{ env('BACKEND_URL') . '/storage/' . $img }}">
                                            </div>
                                        </div>
                                    @empty
                                        <div>
                                            <div class="thumb">
                                                <img src="{{ asset('assets/img/product/product-d-1-1.png') }}">
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-9">
                                <div class="product-big-img vs-carousel" data-slide-show="1" data-fade="true"
                                    data-asnavfor=".product-thumb-slide">
                                    @forelse($product['images'] ?? [] as $img)
                                        <div class="img">
                                            <img src="{{ env('BACKEND_URL') . '/storage/' . $img }}">
                                        </div>
                                    @empty
                                        <div class="img">
                                            <img src="{{ asset('assets/img/product/product-d-1-1.png') }}">
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="product-about">
                            <div class="product-rating">
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="product-rating__total">Review (03)</span>
                                <span class="available"><i class="far fa-check"></i>Available</span>
                            </div>
                            <h2 class="product-title">{{ $product['name'] ?? 'Category' }}</h2>
                            <div class="actions">
                                <div class="quantity">
                                    <div class="quantity__field quantity-container">
                                        <input type="number" id="quantity" class="qty-input" step="1" min="1"
                                            max="100" name="quantity" value="01" title="Qty">
                                        <div class="quantity__buttons">
                                            <button class="quantity-plus qty-btn"><i class="fal fa-plus"></i></button>
                                            <button class="quantity-minus qty-btn"><i class="fal fa-minus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <p class="product-price"> Rs.{{ $product['discount_price'] ?? '0' }}
                                    <del>Rs.{{ $product['price'] ?? '0' }}</del>
                                </p>
                                <p>Free Shipping On This Item</p>
                                <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm" class="d-inline">
                                    @csrf
                                    {{-- Required hidden fields --}}
                                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                    <input type="hidden" name="product_name" value="{{ $product['name'] }}">
                                    <input type="hidden" name="product_slug"
                                        value="{{ $product['slug'] ?? 'product-' . $product['id'] }}">
                                    <input type="hidden" name="product_image" value="{{ $product['images'][0] ?? '' }}">

                                    {{-- Price fields for discount logic --}}
                                    <input type="hidden" name="product_price"
                                        value="{{ $product['discount_price'] ?? $product['price'] }}">
                                    <input type="hidden" name="original_price" value="{{ $product['price'] }}">
                                    <input type="hidden" name="discount_percentage"
                                        value="{{ $product['discount_percentage'] ?? 0 }}">

                                    {{-- ✅ Quantity field - yahi value cart mein jayegi --}}
                                    <input type="hidden" name="quantity" id="form_quantity" value="1">

                                    <button type="submit" class="vs-btn add-to-cart-btn">
                                        <i class="far fa-shopping-basket"></i> Add to Cart
                                    </button>
                                </form>
                                <a href="#" class="icon-btn"><i class="far fa-heart"></i></a>
                            </div>
                            <div class="product_meta">
                                <span class="sku_wrapper">
                                    <p>SKU:</p> <span class="sku">{{ $product['sku'] ?? '#WE' }}</span>
                                </span>
                                <span class="posted_in">
                                    {{-- <p>Category:</p> <a href="#" rel="tag">organic , </a><a href="#" rel="tag"> food , </a> <a href="#" rel="tag"> natural</a> --}}
                                </span>
                            </div>
                            <div class="shep-img">
                                <img src="{{ url('assets/img/service/selling-img-1-2.png') }}" alt="selling-img">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-description">
                    <div class="product-description__tab">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab"
                                    aria-controls="pills-home" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-uses-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-uses" type="button" role="tab"
                                    aria-controls="pills-uses" aria-selected="true">Uses</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-directions-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-directions" type="button" role="tab"
                                    aria-controls="pills-directions" aria-selected="true">Directions for Use</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-cautions-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-cautions" type="button" role="tab"
                                    aria-controls="pills-cautions" aria-selected="true">Cautions</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-benefits-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-benefits" type="button" role="tab"
                                    aria-controls="pills-benefits" aria-selected="true">Primary Benefits</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-ingredients-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-ingredients" type="button" role="tab"
                                    aria-controls="pills-ingredients" aria-selected="true">Ingredients</button>
                            </li>
                            {{-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-information-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-information" type="button" role="tab"
                                    aria-controls="pills-information" aria-selected="false">Additional
                                    Information</button>
                            </li> --}}

                        </ul>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
    
    <!-- Description Tab -->
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class="description">
            <h3 class="description-title h5">Description</h3>
            <p class="text">
                {{ $product['description'] ?? 'No description available' }}
            </p>
            <div class="description-img">
                <img src="{{ url('assets/img/bg/product-details-bg.jpg') }}" alt="product-details">
            </div>
        </div>
    </div>

    <!-- Uses Tab -->
    <div class="tab-pane fade" id="pills-uses" role="tabpanel" aria-labelledby="pills-uses-tab">
        <div class="product-information">
            <div class="description">
                <h3 class="description-title h5">Uses</h3>
                @if (!empty($product['uses']))
                    <ul class="list-unstyled mb-0 mt-3">
                        @foreach (preg_split('/[\n,]+/', trim($product['uses'] ?? ''), -1, PREG_SPLIT_NO_EMPTY) as $use)
                            <li class="d-flex align-items-start py-2 border-bottom">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <span>{{ trim($use) }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No uses information available.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Directions for Use Tab -->
    <div class="tab-pane fade" id="pills-directions" role="tabpanel" aria-labelledby="pills-directions-tab">
        <div class="product-information">
            <div class="description">
                <h3 class="description-title h5">Directions for Use</h3>
                @if (!empty($product['directions_for_use']))
                   <p class="text">{{$product['directions_for_use']}}</p>
                @else
                    <p class="text-muted">No directions available.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Cautions Tab -->
    <div class="tab-pane fade" id="pills-cautions" role="tabpanel" aria-labelledby="pills-cautions-tab">
        <div class="product-information">
            <div class="description">
                <h3 class="description-title h5">Cautions</h3>
                @if (!empty($product['cautions']))
                   <p class="text">{{$product['cautions']}}</p>
                @else
                    <p class="text-muted">No directions available.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Primary Benefits Tab -->
    <div class="tab-pane fade" id="pills-benefits" role="tabpanel" aria-labelledby="pills-benefits-tab">
        <div class="product-information">
            <div class="description">
                <h3 class="description-title h5">Primary Benefits</h3>
                @if (!empty($product['primary_benefits']))
                    <ul class="list-unstyled mb-0 mt-3">
                        @foreach (preg_split('/[\n,]+/', trim($product['primary_benefits'] ?? ''), -1, PREG_SPLIT_NO_EMPTY) as $benefit)
                            <li class="d-flex align-items-start py-2 border-bottom">
                                <i class="fas fa-star text-info me-2 mt-1"></i>
                                <span>{{ trim($benefit) }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No benefits information available.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Ingredients Tab -->
    <div class="tab-pane fade" id="pills-ingredients" role="tabpanel" aria-labelledby="pills-ingredients-tab">
        <div class="product-information">
            <div class="description">
                <h3 class="description-title h5">Ingredients</h3>
                @if (!empty($product['ingredients']))
                   <p class="text">{{$product['ingredients']}}</p>
                @else
                    <p class="text-muted">No directions available.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Additional Information Tab -->
    <div class="tab-pane fade" id="pills-information" role="tabpanel" aria-labelledby="pills-information-tab">
        <div class="product-information">
            <h3 class="description-title h5">Additional Information</h3>
            <table class="product-information__item table">
                <tbody>
                    <tr>
                        <th class="product-information__name" scope="row">Type</th>
                        <td>{{ $category['name'] ?? 'No category available' }}</td>
                    </tr>
                    <tr>
                        <th class="product-information__name" scope="row">Size</th>
                        <td>{{ $product['size'] ?? 'No size available' }}</td>
                    </tr>
                    <tr>
                        <th class="product-information__name" scope="row">Brand</th>
                        <td>{{ $product['brand'] ?? 'VSR' }}</td>
                    </tr>
                    <tr>
                        <th class="product-information__name" scope="row">Organic</th>
                        <td>100%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reviews Tab -->
    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
        <h3 class="description-title h5">Reviews</h3>
        <div class="row woocommerce-reviews">
            <h2 class="h5 mt-4">0.5 Reviews</h2>
            <div class="product-rating">
                <div class="rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <span class="product-rating__total">Review (03)</span>
            </div>
            <div class="col-lg-6">
                <div class="vs-comments-wrap">
                    <ul class="comment-list">
                        <li class="review vs-comment-item">
                            <div class="vs-post-comment">
                                <div class="comment-avater">
                                    <img src="assets/img/blog/comment-author-1.jpg" alt="Comment Author">
                                </div>
                                <div class="comment-content">
                                    <div class="comment-content__header">
                                        <div class="review-rating">
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                        <h4 class="name h4">Thomas Walkar</h4>
                                        <span class="commented-on"><i class="fal fa-calendar-alt"></i> 22 April, 2022</span>
                                    </div>
                                    <p class="text">Delivered ye sportsmen zealously arranging frankness estimable any article enabled musical shyness yet sixteen.</p>
                                </div>
                            </div>
                        </li>
                        <li class="review vs-comment-item">
                            <div class="vs-post-comment">
                                <div class="comment-avater">
                                    <img src="assets/img/blog/comment-author-2.jpg" alt="Comment Author">
                                </div>
                                <div class="comment-content">
                                    <div class="comment-content__header">
                                        <div class="review-rating">
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                        <h4 class="name h4">Crish Thomas</h4>
                                        <span class="commented-on"><i class="fal fa-calendar-alt"></i> 22 April, 2022</span>
                                    </div>
                                    <p class="text">Delivered ye sportsmen zealously arranging frankness estimable any article enabled musical shyness yet sixteen.</p>
                                </div>
                            </div>
                        </li>
                        <li class="review vs-comment-item">
                            <div class="vs-post-comment">
                                <div class="comment-avater">
                                    <img src="assets/img/blog/comment-author-3.jpg" alt="Comment Author">
                                </div>
                                <div class="comment-content">
                                    <div class="comment-content__header">
                                        <div class="review-rating">
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                        <h4 class="name h4">Millem Jakson</h4>
                                        <span class="commented-on"><i class="fal fa-calendar-alt"></i> 23 April, 2022</span>
                                    </div>
                                    <p class="text">Delivered ye sportsmen zealously arranging frankness estimable any article enabled musical shyness yet sixteen.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="vs-comment-form review-form">
                    <div id="respond" class="comment-respond">
                        <div class="form-title mb-4">
                            <h3 class="description-title h5">Post Review</h3>
                            <div class="rating-select">
                                <label>Your Rating</label>
                                <p class="stars">
                                    <span>
                                        <a class="star-1" href="#">1</a>
                                        <a class="star-2" href="#">2</a>
                                        <a class="star-3" href="#">3</a>
                                        <a class="star-4" href="#">4</a>
                                        <a class="star-5" href="#">5</a>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" placeholder="Complete Name">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" placeholder="Email Address">
                            </div>
                            <div class="col-12 form-group">
                                <textarea class="form-control" placeholder="Review"></textarea>
                            </div>
                            <div class="col-12 form-group mb-0">
                                <div class="custom-checkbox notice">
                                    <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes">
                                    <label for="wp-comment-cookies-consent"> Save my name, email, and website in this browser for the next time I comment.</label>
                                </div>
                                <button class="vs-btn"> <span class="vs-btn__bar"></span>Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> <!-- ✅ END tab-content -->
                @else
                    <p>No Product Found</p>
            @endif

        </div>
    </div>

@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ✅ Quantity Buttons - Update both input AND hidden form field
            const qtyInput = document.querySelector('.qty-input');
            const formQuantity = document.getElementById('form_quantity');

            document.querySelector('.quantity-plus')?.addEventListener('click', function(e) {
                e.preventDefault();
                let qty = parseInt(qtyInput.value) || 1;
                qty = Math.min(100, qty + 1); // Max 100
                qtyInput.value = qty;
                if (formQuantity) formQuantity.value = qty; // ✅ Sync with form
            });

            document.querySelector('.quantity-minus')?.addEventListener('click', function(e) {
                e.preventDefault();
                let qty = parseInt(qtyInput.value) || 1;
                qty = Math.max(1, qty - 1); // Min 1
                qtyInput.value = qty;
                if (formQuantity) formQuantity.value = qty; // ✅ Sync with form
            });

            // ✅ Manual input change - bhi sync kare
            qtyInput?.addEventListener('change', function() {
                let val = parseInt(this.value) || 1;
                val = Math.max(1, Math.min(100, val));
                this.value = val;
                if (formQuantity) formQuantity.value = val; // ✅ Sync with form
            });

            // ✅ AJAX Add to Cart (Optional - agar aap bina page reload ke cart update karna chahti hain)
            const cartForm = document.getElementById('addToCartForm');
            if (cartForm) {
                cartForm.addEventListener('submit', function(e) {
                    // Agar aap AJAX use karna chahti hain toh uncomment karein:
                    /*
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const btn = this.querySelector('.add-to-cart-btn');
                    const originalText = btn.innerHTML;
                    
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                    btn.disabled = true;
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            // Update side cart badge
                            const badge = document.getElementById('cartCountBadge');
                            if(badge) badge.textContent = data.cart_count;
                            
                            // Show success toast
                            if(typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: 'Added!',
                                    text: data.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false,
                                    toast: true,
                                    position: 'top-end'
                                });
                            }
                        }
                    })
                    .catch(err => console.error(err))
                    .finally(() => {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    });
                    */


                });
            }
        });
    </script>
@endpush
