    @extends('frontend.layout.master')

    @section('content')

    <!--==============================
        Breadcumb
    ============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ url('assets/img/breadcrumb/breadcrumb.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">My Wishlist</h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Wishlist</li>
                </ul>
            </div>
        </div>
    </div>

    <!--==============================
        Wishlist Area
    ============================== -->
    <section class="wishlist space">
        <div class="container">
            @if(count($products) > 0)
                <div class="table-responsive">
                    <table class="table wishlist-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Stock Status</th>
                                <th>Add to Cart</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                @php
                                    $image = $product['images'][0] ?? null;
                                @endphp
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="{{ route('product-details', $product['slug']) }}">
                                            <img src="{{ $image ? env('BACKEND_URL') . '/storage/' . $image : asset('assets/img/product/product-1-1.png') }}" 
                                                alt="{{ $product['name'] }}">
                                        </a>
                                    </td>
                                    <td class="product-price">
                                        <span class="amount">
                                            <del>Rs.{{ number_format($product['price'], 2) }}</del>
                                            Rs.{{ number_format($product['discount_price'] ?? $product['price'], 2) }}
                                        </span>
                                    </td>
                                    <td class="product-stock">
                                        <span class="in-stock text-success">In Stock</span>
                                    </td>
                                    <td class="product-add-to-cart">
    @php
        $isInCart = in_array($product['id'], $cart_product_ids ?? []);
    @endphp
    
    @if($isInCart)
        {{-- ✅ Already in cart - show disabled state --}}
        <button class="vs-btn btn-success" disabled>
            <i class="fas fa-check"></i> Added to Cart
        </button>
    @else
        {{-- ✅ Not in cart - show add button --}}
        <form action="{{ route('cart.add') }}" method="POST" class="addToCartForm">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
            <input type="hidden" name="product_name" value="{{ $product['name'] }}">
            
            {{-- ✅ Send discounted price as product_price --}}
            <input type="hidden" name="product_price" 
                   value="{{ $product['discount_price'] ?? $product['price'] }}">
            
            {{-- ✅ Send original price for reference --}}
            <input type="hidden" name="original_price" value="{{ $product['price'] }}">
            <input type="hidden" name="discount_percentage" 
                   value="{{ $product['discount_percentage'] ?? 0 }}">
            
            <input type="hidden" name="product_slug" value="{{ $product['slug'] }}">
            <input type="hidden" name="product_image" 
                   value="{{ $product['images'][0] ?? '' }}">
            <input type="hidden" name="quantity" value="1">
            
            <button type="submit" class="vs-btn add-to-cart-btn">
                <i class="far fa-shopping-basket"></i> Add to Cart
            </button>
        </form>
    @endif
</td>
                                    <td class="product-remove">
                                        <button class="remove-wishlist btn btn-link text-danger" 
                                                data-product-id="{{ $product['id'] }}">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="cart-actions mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('products') }}" class="vs-btn">Continue Shopping</a>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="vs-btn">Move All to Cart</button>
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-wishlist text-center py-5">
                    <i class="far fa-heart fa-4x text-muted mb-4"></i>
                    <h3>Your wishlist is empty</h3>
                    <p class="text-muted mb-4">Add items you love to your wishlist</p>
                    <a href="{{ route('products') }}" class="vs-btn">Browse Products</a>
                </div>
            @endif
        </div>
    </section>

    @endsection

   @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ✅ Add to Cart from Wishlist - With Button State Update
    document.querySelectorAll('.wishlist-table .addToCartForm').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = this.querySelector('.add-to-cart-btn');
            const originalText = btn.innerHTML;
            const productId = this.querySelector('[name="product_id"]').value;
            const row = this.closest('tr');
            const productName = row.querySelector('.product-thumbnail img')?.alt || 'Product';
            
            // Show loading state
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // ✅ Update button to "Added" state
                    const cell = btn.closest('td');
                    cell.innerHTML = `
                        <button class="vs-btn btn-success" disabled>
                            <i class="fas fa-check"></i> Added to Cart
                        </button>
                    `;
                    
                    // ✅ Update cart badge in header
                    updateCartBadge(data.cart_count ?? 0);
                    
                    // ✅ Show success toast
                    showToast('Added!', `"${productName}" added to cart.`, 'success');
                    
                } else {
                    // Revert button on error
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    showToast('Error', data.message || 'Failed to add.', 'error');
                }
            })
            .catch(error => {
                console.error('Add to cart error:', error);
                btn.disabled = false;
                btn.innerHTML = originalText;
                showToast('Error', 'Failed to add to cart.', 'error');
            });
        });
    });
    
    // ✅ Remove from Wishlist with Badge Update
    document.querySelectorAll('.remove-wishlist').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const row = this.closest('tr');
            const productName = row.querySelector('.product-thumbnail img')?.alt || 'Product';
            
            // Show loading
            const originalIcon = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;
            
            fetch("{{ route('wishlist.remove') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove row with animation
                    row.style.opacity = '0';
                    row.style.transition = 'opacity 0.3s';
                    setTimeout(() => row.remove(), 300);
                    
                    // Update wishlist badge
                    updateWishlistBadge(data.wishlist_count ?? 0);
                    
                    showToast('Removed', `"${productName}" removed from wishlist.`, 'info');
                    
                    // Reload if empty
                    if (document.querySelectorAll('.wishlist-table tbody tr').length <= 1) {
                        setTimeout(() => location.reload(), 1000);
                    }
                } else {
                    throw new Error(data.message || 'Failed to remove');
                }
            })
            .catch(error => {
                console.error('Remove error:', error);
                showToast('Error', 'Failed to remove item.', 'error');
            })
            .finally(() => {
                button.innerHTML = originalIcon;
                button.disabled = false;
            });
        });
    });
    
    // ✅ Update Cart Badge Function
    function updateCartBadge(count) {
        const badge = document.getElementById('cartCountBadge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }
    }
    
    // ✅ Update Wishlist Badge Function
    function updateWishlistBadge(count) {
        const badge = document.getElementById('wishlistCountBadge');
        if (badge) {
            badge.textContent = count;
            badge.setAttribute('data-count', count);
            badge.style.display = count > 0 ? 'flex' : 'none';
            
            // Animation
            badge.classList.add('updated');
            setTimeout(() => badge.classList.remove('updated'), 300);
        }
    }
    
    // ✅ Toast Notification Function
    function showToast(title, message, type = 'success') {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: title,
                text: message,
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
        } else {
            alert(`${type.toUpperCase()}: ${message}`);
        }
    }
    
});
</script>
@endpush