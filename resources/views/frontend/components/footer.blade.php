
    <!--==============================
			Footer Area
	==============================-->
    <footer class="footer-wrapper  footer-layout1" data-bg-src="{{ url ('assets/img/bg/footer.png')}}">
        <div class="footer-top">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-4 col-md-6">
                        <div class="media-style1">
                            <div class="media-icon"><img src="{{ url ('assets/img/icon/icon-1-1.png')}}" alt="icon"></div>
                            <div class="media-body">
                                <h3 class="media-title">Phone No:</h3>
                                <p class="media-info"><a href="tel:{{ $settings['phone1'] }}">{{ $settings['phone1'] ?? '9999999999' }}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="media-style1">
                            <div class="media-icon"><img src="{{ url ('assets/img/icon/icon-1-2.png')}}" alt="icon"></div>
                            <div class="media-body">
                                <h3 class="media-title">Email Address:</h3>
                                <p class="media-info"><a href="mailto:{{ $settings['email'] ?? '' }}"> {{ $settings['email'] ?? 'example@domain.com' }}</a> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="media-style1">
                            <div class="media-icon"><img src="{{ url ('assets/img/icon/icon-1-3.png')}}" alt="icon"></div>
                            <div class="media-body">
                                <h3 class="media-title">Location:</h3>
                                <p class="media-info">{{ $settings['location'] ?? 'Default Location' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-md-6">
                        <div class="widget footer-widget">
                            <div class="vs-widget-about">
                                <div class="footer-logo">
                                  @php
                                        $image = is_object($settings)
                                            ? $settings->white_logo ?? ($settings['white_logo'] ?? null)
                                            : $settings['white_logo'] ?? null;
                                    @endphp

                                       <a href="{{ route('home') }}">
                                        <img src="{{ $image ? $image : asset('assets/img/product/product-1-1.png') }}"
                                            alt="product" style="max-height: 50px; width: auto;">
                                    </a>
                                </div>
                                <p class="footer-text">{{ strip_tags($settings['about']) }}</p>
                                <div class="footer-social">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-3">
                        <div class="widget widget_categories  footer-widget">
                            <h3 class="widget_title">Company</h3>
                            <ul>
                                <li><a href="{{ route('about-us') }}">About Us</a></li>
                                <li><a href="{{ route('products') }}">Our products</a></li>
                                <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                                <li><a href="{{ route('blogs') }}">News & Blogs</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-3">
                        <div class="widget widget_categories  footer-widget">
                            <h3 class="widget_title">Legals</h3>
                            <ul>
                                <li><a href="{{ route('terms-and-conditions') }}">Terms & Conditions</a></li>
                                <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                                <li><a href="{{ route('accessibility') }}">Accessibility</a></li>
                                {{-- <li><a href="{{ route('shipping-policy') }}">Consent Preferences</a></li> --}}
                                <li><a href="{{ route('cancel-refund-policy') }}">Cancellation & Refund Process</a>
                                </li>
                                <li><a href="{{ route('disclaimer') }}">Disclaimer</a></li>
                                <li><a href="{{ route('shipping-policy') }}">Shipping Policy</a></li>
                                <li><a href="{{ route('grievance-redressal') }}">Grievance Redressal</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="widget widget_newsletter footer-widget">
                            <h4 class="widget_title">Subscribe Newsletter</h4>
                             <form class="newsletter-form" id="newsletterForm" action="{{ route('subscribe') }}"
                                method="POST">
                                @csrf
                                <p class="form_text">Enter your email and get recent news & recent offers update.</p>
                                <div class="search-btn">
                                   <input class="form-control" type="email" name="email" id="newsletterEmail"
                                        placeholder="Enter your email address...." required>
                                    <button type="submit" class="icon-btn" class="vs-btn" id="subscribeBtn"><i class="fas fa-paper-plane"></i></button>
                                </div>
                                 <!-- Hidden feedback message -->
                                <p id="formMessage" class="mt-2 text-white" style="display:none; font-size: 14px;"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrap">
            <div class="container">
                <div class="row justify-content-xl-between justify-content-center align-items-center">
                    <div class="col-auto">
                     @php
                            $settings = $settings ?? null;
                            $companyName = $settings?->company_name ?? ($settings['company_name'] ?? 'VSR');
                        @endphp

                         <p class="copyright-text"> <i class="fal fa-copyright"></i> <?php echo date('Y'); ?> <a
                                href="{{ route('home') }}">{{ $companyName }}</a>. All Rights Reserved By <a
                                href="#">Vibrantick Infotech Solutions</a></p>
                    </div>
                    
                </div>
            </div>
        </div>
    </footer>  
    <!-- Scroll To Top -->
    <a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>
    <!-- Add this Script -->
    <script>
        document.getElementById('newsletterForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Stop page reload

            const form = this;
            const btn = document.getElementById('subscribeBtn');
            const message = document.getElementById('formMessage');
            const emailInput = document.getElementById('newsletterEmail');

            // Show loading state
           
            btn.disabled = true;
            message.style.display = 'none';

            // Send data via AJAX
            fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Laravel needs this for JSON responses
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        message.style.color = '#00ff00'; // Green
                        message.textContent = data.message;
                        emailInput.value = ''; // Clear input
                    } else {
                        message.style.color = '#ff4d4d'; // Red
                        message.textContent = data.message;
                    }
                    message.style.display = 'block';
                })
                .catch(error => {
                    message.style.color = '#ff4d4d';
                    message.textContent = 'Network error. Please try again.';
                    message.style.display = 'block';
                })
                .finally(() => {
                    
                    btn.disabled = false;
                });
        });
    </script>
