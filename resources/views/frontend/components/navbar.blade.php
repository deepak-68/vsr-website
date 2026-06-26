   <header class="vs-header header-layout3">
       <div class="header-top">
           <div class="container">
               <div class="row justify-content-between align-items-center">
                   <div class="col-auto">
                       <div class="header-links">
                           <ul>
                               <li><i class="far fa-map-marker-alt"></i>{{ $settings['location'] ?? 'Fazilka' }}</li>
                               <li><i class="far fa-envelope"></i><a
                                       href="mailto:{{ $settings['email'] ?? 'info@gmail.com' }}">{{ $settings['email'] }}</a>
                               </li>
                               <li><i class="far fa-phone-alt"></i><a
                                       href="tel:{{ $settings['phone1'] ?? '9999999999' }}">{{ $settings['phone1'] }}</a>
                               </li>
                               {{-- <li><i class="far fa-clock"></i>Mon - Sat: 09.00 to 06.00</li> --}}
                           </ul>
                       </div>
                   </div>
                   <div class="col-auto">
                       <div class="social-style1">
                           <a href="#"><i class="fab fa-facebook-f"></i></a>
                           <a href="#"><i class="fab fa-instagram"></i></a>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <div class="sticky-wrapper">
           <div class="sticky-active">
               <div class="menu-area">
                   <div class="container">
                       <div class="row align-items-center justify-content-between">
                           <div class="col-auto d-lg-block d-none">
                               <div class="main-menu2">
                                   <div class="header-icons">
                                       <a href="#" class="vs-menu-toggle">
                                           <p class="bar-btn">
                                               <span class="bar"></span>
                                               <span class="bar bar2"></span>
                                               <span class="bar"></span>
                                           </p>menu
                                       </a>
                                       <a href="{{ route('products') }}" class="link-btn searchBoxTggler">Shop & Earn</a>
                                   </div>
                               </div>
                           </div>
                           <div class="col text-center">
                               @php
                                   $settings = $settings ?? null;
                                   $whiteLogo = $settings?->white_logo ?? ($settings['white_logo'] ?? null);
                                   $blackLogo = $settings?->black_logo ?? ($settings['black_logo'] ?? null);
                                   $fallback = asset('assets/img/logo-2.png');
                               @endphp
                               <div class="header-logo">
                                   <a class="logo1" href="{{ route('home') }}">
                                       <img src="{{ $whiteLogo ?: $fallback }}"
                                           alt="{{ $settings?->company_name ?? 'Logo' }}"
                                           style="max-height: 50px; width: auto;">
                                   </a>

                                   <a class="logo2" href="{{ route('home') }}">
                                       <img src="{{ $blackLogo ?: $fallback }}"
                                           alt="{{ $settings?->company_name ?? 'Logo' }}"
                                           style="max-height: 50px; width: auto;">
                                   </a>
                               </div>
                           </div>
                           <div class="col-auto d-lg-none">
                               <button class="vs-menu-toggle d-inline-block">
                                   <i class="fal fa-bars"></i>
                               </button>
                           </div>
                           <div class="col-auto d-lg-block d-none">
                               <div class="header-icons">

                                   {{-- 🔹 Auth Check: Logged In vs Guest --}}
                                   @auth
                                       <!-- User Dropdown -->
                                       <div class="dropdown">
                                           <a href="#" class="link-btn dropdown-toggle" id="userDropdown"
                                               data-bs-toggle="dropdown" aria-expanded="false">
                                               <i class="fal fa-user"></i>
                                               {{ Auth::user()->name }}
                                           </a>

                                           <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
                                               style="min-width: 200px;">

                                        
                                               <!-- Wishlist Link (Optional) -->
                                               <li>
                                                   <a class="dropdown-item py-2 px-3" href="{{ route('wishlist') }}">
                                                       <i class="far fa-heart me-2 text-muted"></i>Wishlist
                                                   </a>
                                               </li>

                                               <li>
                                                   <hr class="dropdown-divider my-1">
                                               </li>

                                               <!-- Logout -->
                                               <li>
                                                   <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                                       @csrf
                                                       <button type="submit"
                                                           class="dropdown-item py-2 px-3 text-danger border-0 bg-transparent w-100 text-start">
                                                           <i class="far fa-sign-out me-2"></i>Logout
                                                       </button>
                                                   </form>
                                               </li>
                                           </ul>
                                       </div>
                                   @else
                                       <!-- Guest: Show Login Link -->
                                       {{-- <a href="{{ route('login') }}" class="link-btn">
                                           <i class="fal fa-user"></i>Login
                                       </a> --}}

                                       <a href="https://user.visoraushaven.in/" class="link-btn">
                                           <i class="fal fa-user"></i>Login
                                       </a>
                                       <a href="https://user.visoraushaven.in/register" class="link-btn">
                                           <i class="fal fa-user"></i>Register
                                       </a>
                                   @endauth

                                   {{-- Wishlist Icon --}}
                                   <a href="{{ route('wishlist') }}" class="icon-btn position-relative">
                                       <i class="far fa-heart"></i>
                                       <span class="badge" id="wishlistCountBadge">
                                           {{ count(session('wishlist', [])) }}
                                       </span>
                                   </a>

                                   {{-- Cart Icon --}}
                                   <a href="#" class="icon-btn style2 sideCartToggler">
                                       <i class="fal fa-shopping-cart"></i>
                                       <span class="badge" id="cartCountBadge">
                                           {{ array_sum(array_column(session('cart', []), 'quantity')) }}
                                       </span>
                                   </a>

                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </header>