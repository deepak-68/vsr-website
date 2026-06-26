<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>VSR</title>
    <meta name="author" content="Vecuro">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- ✅ Favicons with NULL-SAFE code -->
    @php
        // 🔹 Step 1: Agar $settings undefined hai, toh null set karein
        $settings = $settings ?? null;
        
        // 🔹 Step 2: Favicon fetch karein (object/array dono ke liye safe)
        $favicon = null;
        if ($settings) {
            $favicon = is_object($settings) 
                ? ($settings->favicon ?? ($settings['favicon'] ?? null))
                : ($settings['favicon'] ?? null);
        }
    @endphp

    <link rel="shortcut icon" 
          href="{{ $favicon ? $favicon : asset('assets/img/favicon.ico') }}" 
          type="image/x-icon">
    
    <link rel="icon" 
          href="{{ $favicon ?  $favicon : asset('assets/img/favicon.ico') }}" 
          type="image/x-icon">

    <!--==============================
	  Google Fonts
	============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="../../css2?family=Fredoka:wght@400;500;600;700&family=DM+Sans:wght@400&display=swap" rel="stylesheet">


    <!--==============================
	    All CSS File
	============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{url ('assets/css/bootstrap.min.css')}}">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="{{url ('assets/css/fontawesome.min.css')}}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{url ('assets/css/magnific-popup.min.css')}}">
    <!-- Slick Slider -->
    <link rel="stylesheet" href="{{url ('assets/css/slick.min.css')}}">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{url ('assets/css/style.css')}}">
<style>
    .swal2-popup,
    .swal2-container,
    .swal2-shown {
        z-index: 9999999 !important;
    }
</style>
<style>
    /* ✅ Wishlist Badge - Matches cart badge style */
    .wishlist-count-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #e74c3c;  /* Red color - change to match your theme */
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 11px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        padding: 0;
        min-width: 20px;
    }
    
    /* Hide badge when count is 0 */
    .wishlist-count-badge:empty,
    .wishlist-count-badge[data-count="0"] {
        display: none;
    }
    
    /* Optional: Animation when count changes */
    .wishlist-count-badge.updated {
        animation: pulse 0.3s ease;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }
</style>
</head>

<body>

@include('frontend.components.navbar')
@include('frontend.components.mobile-menu')
@include('frontend.components.cart')

@yield('content')


@include('frontend.components.footer')








    <!--==============================
        All Js File
    ============================== -->
    <!-- Jquery -->
    <script src="{{url ('assets/js/vendor/jquery-3.6.0.min.js')}}"></script>
    <!-- Slick Slider -->
    <script src="{{url ('assets/js/slick.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{url ('assets/js/bootstrap.min.js')}}"></script>
    <!-- Magnific Popup -->
    <script src="{{url ('assets/js/jquery.magnific-popup.min.js')}}"></script>
    <!-- Isotope Filter -->
    <script src="{{url ('assets/js/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{url ('assets/js/isotope.pkgd.min.js')}}"></script>
    <!-- Main Js File -->
    <script src="{{url ('assets/js/main.js')}}"></script>
@stack('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ✅ Calculate Cart Totals Function (Frontend Only)
    function updateCartTotals() {
        let subtotal = 0;
        
        document.querySelectorAll('#cartItemsBody tr.cart_item').forEach(row => {
            const totalValue = row.querySelector('.total-value');
            if (totalValue) {
                const lineTotal = parseFloat(totalValue.textContent.replace(/,/g, '')) || 0;
                subtotal += lineTotal;
            }
        });
        
        const shippingRadio = document.querySelector('input[name="shipping_method"]:checked');
        const shipping = shippingRadio ? parseFloat(shippingRadio.value) || 0 : 50;
        const orderTotal = subtotal + shipping;
        
        const subtotalEl = document.getElementById('subtotalValue');
        const orderTotalEl = document.getElementById('orderTotalValue');
        
        if (subtotalEl) subtotalEl.textContent = subtotal.toFixed(2);
        if (orderTotalEl) orderTotalEl.textContent = orderTotal.toFixed(2);
    }

    // ✅ Quantity buttons - frontend display only (NO AJAX)
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const container = this.closest('.quantity-container');
            const input = container.querySelector('.qty-input');
            const row = this.closest('tr.cart_item');
            
            let qty = parseInt(input.value) || 1;
            const price = parseFloat(row.dataset.price) || 0;
            
            if (this.classList.contains('quantity-plus')) {
                qty = qty + 1;
            } else if (qty > 1) {
                qty = qty - 1;
            }
            
            qty = Math.max(1, qty);
            input.value = qty;
            
            // Update line total display
            const lineTotal = price * qty;
            const totalValue = row.querySelector('.total-value');
            if (totalValue) {
                totalValue.textContent = lineTotal.toFixed(2);
            }
            
            updateCartTotals();
            // ❌ NO AJAX - form submission will save to session
        });
    });

    // ✅ Input validation only (NO AJAX)
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', function() {
            let val = parseInt(this.value) || 1;
            val = Math.max(1, Math.min(100, val));
            this.value = val;
            
            const row = this.closest('tr.cart_item');
            const price = parseFloat(row.dataset.price) || 0;
            const lineTotal = price * val;
            
            const totalValue = row.querySelector('.total-value');
            if (totalValue) {
                totalValue.textContent = lineTotal.toFixed(2);
            }
            
            updateCartTotals();
            // ❌ NO AJAX - form submission will save to session
        });
    });

    // ✅ Shipping method change
    document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
        radio.addEventListener('change', updateCartTotals);
    });

   // ✅ Remove button with better error handling
document.addEventListener('click', function(e) {
    const removeBtn = e.target.closest('.remove-cart');
    if (!removeBtn) return;
    
    e.preventDefault();
    e.stopPropagation();
    
    const productId = removeBtn.dataset.id;
    const productName = removeBtn.dataset.name || 'This item';
    const row = removeBtn.closest('tr.cart_item');
    
    Swal.fire({
        title: 'Remove Item?',
        text: `Remove "${productName}" from your cart?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Remove!',
        cancelButtonText: 'Cancel'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                // Show loading
                Swal.fire({
                    title: 'Removing...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
                
                // Make the request
                const response = await fetch("{{ route('cart.remove') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        product_id: productId 
                    })
                });
                
                // Check if response is OK
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                // Try to parse JSON
                let data;
                try {
                    data = await response.json();
                } catch (parseError) {
                    console.error('JSON parse error:', parseError);
                    throw new Error('Invalid response from server');
                }
                
                console.log('Remove response:', data); // Debug log
                
                if (data.success) {
                    // Remove row with animation
                    if (row) {
                        row.style.opacity = '0';
                        row.style.transition = 'opacity 0.3s';
                        setTimeout(() => row.remove(), 300);
                    }
                    
                    // Update totals
                    updateCartTotals();
                    
                    // Update side cart if exists
                    const sideCart = document.getElementById('sideCartList');
                    if (sideCart && data.cart_items) {
                        sideCart.innerHTML = data.cart_items;
                    }
                    
                    // Update badge if exists
                    const badge = document.getElementById('cartCountBadge');
                    if (badge && data.cart_count !== undefined) {
                        badge.textContent = data.cart_count;
                        badge.style.display = data.cart_count > 0 ? 'flex' : 'none';
                    }
                    
                    // Success message
                    Swal.fire({
                        title: 'Removed!',
                        text: `"${productName}" removed from cart.`,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    
                    // Check if cart is now empty
                    const remainingItems = document.querySelectorAll('#cartItemsBody tr.cart_item');
                    if (remainingItems.length === 0) {
                        setTimeout(() => {
                            window.location.href = "{{ route('cart') }}";
                        }, 1500);
                    }
                } else {
                    throw new Error(data.message || 'Failed to remove item');
                }
                
            } catch (error) {
                console.error('Remove error:', error);
                
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Failed to remove item. Please try again.',
                    icon: 'error',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                
                // Reload page to sync with server state
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        }
    });
});

    // ✅ Visual feedback on form submit
    const cartForm = document.getElementById('cartForm');
    if (cartForm) {
        cartForm.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('updateCartBtn');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            }
        });
    }

    // ✅ Initial calculation on page load
    updateCartTotals();


 
    // ✅ Wishlist Toggle with Badge Update
    document.querySelectorAll('.wishlist-toggle').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.dataset.productId;
            const icon = this.querySelector('i');
            const productName = this.closest('.product-style2')?.querySelector('.product-title')?.textContent?.trim() || 'Product';
            
            // Show loading state
            const originalIconClass = icon.className;
            icon.className = 'fas fa-spinner fa-spin';
            this.disabled = true;
            
            fetch("{{ route('wishlist.toggle') }}", {
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
                    // Update icon
                    if (data.in_wishlist) {
                        icon.className = 'fas fa-heart';
                        button.classList.add('active');
                        showToast('Added to Wishlist!', `"${productName}" saved.`, 'success');
                    } else {
                        icon.className = 'far fa-heart';
                        button.classList.remove('active');
                        showToast('Removed from Wishlist', `"${productName}" removed.`, 'info');
                    }
                    
                    // ✅ Update wishlist badge
                    updateWishlistBadge(data.wishlist_count);
                    
                } else {
                    throw new Error(data.message || 'Failed to update wishlist');
                }
            })
            .catch(error => {
                console.error('Wishlist error:', error);
                icon.className = originalIconClass;
                showToast('Error', 'Failed to update wishlist.', 'error');
            })
            .finally(() => {
                this.disabled = false;
            });
        });
    });
    
    // ✅ Update Wishlist Badge Function
    function updateWishlistBadge(count) {
        const badge = document.getElementById('wishlistCountBadge');
        if (badge) {
            badge.textContent = count;
            badge.setAttribute('data-count', count);
            
            // Show/hide based on count
            badge.style.display = count > 0 ? 'flex' : 'none';
            
            // Add animation
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

</body>

</html>
