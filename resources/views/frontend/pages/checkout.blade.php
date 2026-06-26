@extends('frontend.layout.master')

@section('content')
    <!--==============================
        Breadcumb
    ============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ url('assets/img/breadcrumb/breadcrumb.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Checkout</h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Checkout</li>
                </ul>
            </div>
        </div>
    </div>

    <!--==============================
        Checkout Area
    ============================== -->
    <div class="space">
        <div class="vs-checkout-wrapper">
            <div class="container">

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Login Toggle -->
                <div class="woocommerce-form-login-toggle">
                    <div class="woocommerce-info">Returning customer?
                        <a href="#" class="showlogin">Click here to login</a>
                    </div>
                </div>
                <form action="{{ route('login') }}" method="POST" class="woocommerce-form-login" style="display:none;">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <div class="custom-checkbox">
                                    <input type="checkbox" name="remember" id="remembermylogin">
                                    <label for="remembermylogin">Remember Me</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="vs-btn">Login</button>
                                <p class="fs-xs mt-2 mb-0"><a class="text-reset" href="{{ route('password.request') }}">Lost
                                        your password?</a></p>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Coupon Toggle -->
                <div class="woocommerce-form-coupon-toggle">
                    <div class="woocommerce-info">Have a coupon?
                        <a href="#" class="showcoupon">Click here to enter your code</a>
                    </div>
                </div>
                <form action="#" class="woocommerce-form-coupon" style="display:none;">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" name="coupon_code" class="form-control"
                                    placeholder="Write your coupon code">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="vs-btn">Apply coupon</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Main Checkout Form -->
                <form action="{{ route('checkout.process') }}" method="POST" class="woocommerce-checkout mt-40"
                    id="checkout-form">
                    @csrf
                    <input type="hidden" name="terms" value="1" id="terms-accepted">

                    <div class="row">
                        <!-- Billing Details -->
                        <div class="col-lg-6">
                            <h3>Billing Details</h3>
                            <div class="row">
                                <div class="col-12 form-group">
                                    <select class="form-select" name="billing_country" id="billing_country" required>
                                        <option value="">Select Country</option>
                                        <option value="India" {{ old('billing_country') == 'India' ? 'selected' : '' }}>
                                            India</option>
                                        <option value="United States"
                                            {{ old('billing_country') == 'United States' ? 'selected' : '' }}>United States
                                        </option>
                                        <option value="United Kingdom"
                                            {{ old('billing_country') == 'United Kingdom' ? 'selected' : '' }}>United
                                            Kingdom</option>
                                        <option value="Australia"
                                            {{ old('billing_country') == 'Australia' ? 'selected' : '' }}>Australia
                                        </option>
                                        <option value="Canada" {{ old('billing_country') == 'Canada' ? 'selected' : '' }}>
                                            Canada</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="billing_first_name" class="form-control"
                                        placeholder="First Name *" value="{{ old('billing_first_name') }}" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="billing_last_name" class="form-control"
                                        placeholder="Last Name *" value="{{ old('billing_last_name') }}" required>
                                </div>
                                <div class="col-12 form-group">
                                    <input type="text" name="billing_company" class="form-control"
                                        placeholder="Company Name (Optional)" value="{{ old('billing_company') }}">
                                </div>
                                <div class="col-12 form-group">
                                    <input type="text" name="billing_address" class="form-control"
                                        placeholder="Street Address *" value="{{ old('billing_address') }}" required>
                                </div>
                                <div class="col-12 form-group">
                                    <input type="text" name="billing_address_2" class="form-control"
                                        placeholder="Apartment, suite, unit etc. (optional)"
                                        value="{{ old('billing_address_2') }}">
                                </div>
                                <div class="col-12 form-group">
                                    <input type="text" name="billing_city" class="form-control"
                                        placeholder="Town / City *" value="{{ old('billing_city') }}" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="billing_postcode" class="form-control"
                                        placeholder="Postcode / Zip" value="{{ old('billing_postcode') }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" name="billing_state" class="form-control" placeholder="State"
                                        value="{{ old('billing_state') }}">
                                </div>
                                <div class="col-12 form-group">
                                    <input type="email" name="billing_email" class="form-control"
                                        placeholder="Email Address *" value="{{ old('billing_email') }}" required>
                                </div>
                                <div class="col-12 form-group">
                                    <input type="tel" name="billing_phone" class="form-control"
                                        placeholder="Phone Number *" value="{{ old('billing_phone') }}" required>
                                </div>
                                <div class="col-12 form-group">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="accountNewCreate" name="create_account"
                                            value="1">
                                        <label for="accountNewCreate">Create An Account?</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Details -->
                        <div class="col-lg-6">
                            <p id="ship-to-different-address">
                                <input id="ship-to-different-address-checkbox" type="checkbox"
                                    name="ship_to_different_address" value="1">
                                <label for="ship-to-different-address-checkbox">
                                    Ship to a different address? <span class="checkmark"></span>
                                </label>
                            </p>

                            <div class="shipping_address" id="shipping-fields" style="display:none;">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <select class="form-select" name="shipping_country">
                                            <option value="">Select Country</option>
                                            <option value="India">India</option>
                                            <option value="United States">United States</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="Australia">Australia</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="text" name="shipping_first_name" class="form-control"
                                            placeholder="First Name">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="text" name="shipping_last_name" class="form-control"
                                            placeholder="Last Name">
                                    </div>
                                    <div class="col-12 form-group">
                                        <input type="text" name="shipping_address" class="form-control"
                                            placeholder="Street Address">
                                    </div>
                                    <div class="col-12 form-group">
                                        <input type="text" name="shipping_city" class="form-control"
                                            placeholder="Town / City">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="text" name="shipping_postcode" class="form-control"
                                            placeholder="Postcode / Zip">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="text" name="shipping_state" class="form-control"
                                            placeholder="State">
                                    </div>
                                    <div class="col-12 form-group">
                                        <input type="email" name="shipping_email" class="form-control"
                                            placeholder="Email Address">
                                    </div>
                                    <div class="col-12 form-group">
                                        <input type="tel" name="shipping_phone" class="form-control"
                                            placeholder="Phone Number">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 form-group">
                                <textarea name="order_notes" cols="20" rows="5" class="form-control"
                                    placeholder="Notes about your order, e.g. special notes for delivery.">{{ old('order_notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <h4 class="mt-4 pt-lg-2">Your Order</h4>
                    <div class="woocommerce-cart-form">
                        <table class="cart_table mb-20">
                            <thead>
                                <tr>
                                    <th class="cart-col-image">Image</th>
                                    <th class="cart-col-productname">Product Name</th>
                                    <th class="cart-col-price">Price</th>
                                    <th class="cart-col-quantity">Quantity</th>
                                    <th class="cart-col-total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cartItems as $item)
                                    <tr class="cart_item">
                                        <td data-title="Product">
                                            <a class="cart-productimage"
                                                href="{{ !empty($item['slug']) ? route('product-details', $item['slug']) : '#' }}">
                                                <img width="91" height="91"
                                                    src="{{ $item['image'] ? env('BACKEND_URL') . '/storage/' . $item['image'] : asset('assets/img/product/product-1-1.png') }}"
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
                                            <span class="amount">
                                                <bdi><span>Rs.</span>{{ number_format($item['price'], 2) }}</bdi>
                                            </span>
                                        </td>
                                        <td data-title="Quantity">
                                            <strong class="product-quantity">{{ $item['quantity'] }}</strong>
                                        </td>
                                        <td data-title="Total">
                                            <span class="amount">
                                                <bdi><span>Rs.</span>{{ number_format($item['total'], 2) }}</bdi>
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No items in cart</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="checkout-ordertable">
                                <tr class="cart-subtotal">
                                    <th>Subtotal</th>
                                    <td data-title="Subtotal" colspan="4">
                                        <span class="woocommerce-Price-amount amount">
                                            <bdi><span
                                                    class="woocommerce-Price-currencySymbol">Rs.</span>{{ number_format($subtotal, 2) }}</bdi>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="woocommerce-shipping-totals shipping">
                                    <th>Shipping</th>
                                    <td data-title="Shipping" colspan="4">
                                        <span id="shipping-amount">Rs.{{ number_format($shipping, 2) }}</span>
                                        <small class="d-block text-muted">Flat rate • Free shipping over Rs.1000</small>
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <th>Total</th>
                                    <td data-title="Total" colspan="4">
                                        <strong>
                                            <span class="woocommerce-Price-amount amount">
                                                <bdi><span class="woocommerce-Price-currencySymbol">Rs.</span>
                                                    <span id="order-total">{{ number_format($total, 2) }}</span></bdi>
                                            </span>
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Payment Methods -->
                    <div class="mt-lg-3">
                        <div class="woocommerce-checkout-payment">
                            <ul class="wc_payment_methods payment_methods methods">
                               
                               
                                <li class="wc_payment_method payment_method_cod">
                                    <input id="payment_method_cod" type="radio" class="input-radio"
                                        name="payment_method" value="cod">
                                    <label for="payment_method_cod">Cash on Delivery
                                        <img src="assets/img/product/credit-payment.png" alt="COD"
                                            style="height:20px;">
                                    </label>
                                    <div class="payment_box payment_method_cod">
                                        <p>Pay with cash when your order is delivered.</p>
                                    </div>
                                </li>
                                <li class="wc_payment_method payment_method_paypal">
                                    <input id="payment_method_paypal" type="radio" class="input-radio"
                                        name="payment_method" value="paypal">
                                    <label for="payment_method_paypal">PayPal / Card</label>
                                    <div class="payment_box payment_method_paypal">
                                        <p>Pay securely via PayPal or credit/debit card.</p>
                                    </div>
                                </li>
                            </ul>

                            <div class="form-group mt-3">
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="terms" name="terms" required>
                                    <label for="terms">I have read and agree to the <a href=""
                                            target="_blank">Terms & Conditions</a> *</label>
                                </div>
                            </div>

                            <div class="form-row place-order">
                                <button type="submit" class="vs-btn w-100" id="place-order-btn">
                                    Place Order - Rs.<span id="btn-total">{{ number_format($total, 2) }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle login form
            document.querySelector('.showlogin')?.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector('.woocommerce-form-login').style.display =
                    document.querySelector('.woocommerce-form-login').style.display === 'none' ? 'block' :
                    'none';
            });

            // Toggle coupon form
            document.querySelector('.showcoupon')?.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector('.woocommerce-form-coupon').style.display =
                    document.querySelector('.woocommerce-form-coupon').style.display === 'none' ? 'block' :
                    'none';
            });

            // Toggle shipping address
            const shipCheckbox = document.getElementById('ship-to-different-address-checkbox');
            const shippingFields = document.getElementById('shipping-fields');

            shipCheckbox?.addEventListener('change', function() {
                shippingFields.style.display = this.checked ? 'block' : 'none';
                // Enable/disable shipping fields
                shippingFields.querySelectorAll('input, select').forEach(field => {
                    field.required = this.checked;
                });
            });

            // Update totals when country changes (AJAX)
            document.getElementById('billing_country')?.addEventListener('change', function() {
                fetch("{{ route('checkout.shipping') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            country: this.value,
                            postcode: document.querySelector('[name="billing_postcode"]')
                                ?.value || ''
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('shipping-amount').textContent = 'Rs.' + parseFloat(
                                data.shipping).toFixed(2);
                            document.getElementById('order-total').textContent = parseFloat(data.total)
                                .toFixed(2);
                            document.getElementById('btn-total').textContent = parseFloat(data.total)
                                .toFixed(2);
                        }
                    });
            });

            // Form validation before submit
            document.getElementById('checkout-form')?.addEventListener('submit', function(e) {
                const terms = document.getElementById('terms');
                if (!terms?.checked) {
                    e.preventDefault();
                    alert('Please agree to the Terms & Conditions to proceed.');
                    terms.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });

            // Payment method toggle
            document.querySelectorAll('.input-radio[name="payment_method"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.querySelectorAll('.payment_box').forEach(box => {
                        box.style.display = 'none';
                    });
                    const box = this.closest('li').querySelector('.payment_box');
                    if (box) box.style.display = 'block';
                });
            });
        });
    </script>
@endpush
