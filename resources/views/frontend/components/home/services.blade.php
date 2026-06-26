   <!--==============================
    Service Area
    ============================== -->
<section class="service-layout2 space">
    <div class="container">
        @php
            // Direct service data (no loop needed)
            $serviceData = $services[0] ?? null;
            
            if (!$serviceData) {
                $serviceData = is_string($services) ? json_decode($services, true) : $services;
            }
            
            // Handle nested 'service' key if exists
            if (isset($serviceData['service'])) {
                $serviceData = $serviceData['service'];
            }
            
            // Backend URL
            $backendUrl = rtrim(env('BACKEND_URL', url('/')), '/');
            
            // Image helper
            $getImageUrl = function($path) use ($backendUrl) {
                if (empty($path)) return null;
                if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
                return $backendUrl . '/' . ltrim($path, '/');
            };
            
            // Extract data
            $cards = $serviceData['cards'] ?? [];
            $activeItem = $serviceData['active_item'] ?? null;
            $icon = $serviceData['icon'] ?? null;
            $mainImage = $serviceData['main_image'] ?? null;
            $subTitle = $serviceData['sub_title'] ?? 'OUR BEST SERVICES';
            $mainTitle = $serviceData['main_title'] ?? 'We Providing High Quality';
            
            // Build URLs
            $iconUrl = $getImageUrl($icon) ?? asset('assets/img/about/about-bg-2-1.jpg');
            $mainImageUrl = $getImageUrl($mainImage) ?? asset('assets/img/bg/service-img-1.jpg');
        @endphp

        @if($serviceData)
            {{-- Title Area --}}
            <div class="title-area text-center wow fadeInUp wow-animated" data-wow-delay="0.3s">
                <div class="title-img">
                    <img src="{{ asset('assets/img/icon/title-logo.png') }}" alt="title logo">
                </div>
                <span class="sec-subtitle">{{ $subTitle }}</span>
                <h2 class="sec-title">{{ $mainTitle }}</h2>
            </div>

            {{-- Service Content --}}
            <div class="service-style2">
                <div class="row gx-5 align-items-center">
                    
                    {{-- Service List --}}
                    <div class="col-lg-4">
                        <div class="service-list">
                            @if(count($cards) > 0)
                                <ul>
                                    @foreach($cards as $card)
                                        <li>
                                            <a href="{{ route('services') }}" class="vs-btn">
                                                {{ $card['title'] ?? 'Service' }}
                                                <i class="fas fa-angle-double-right"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No services available</p>
                            @endif
                        </div>
                    </div>

                    {{-- Icon & Description --}}
                   {{-- Icon & Description --}}
<div class="col-lg-3">
    <div class="service-inner">
        <div class="service-icon">
            <img src="{{ $iconUrl }}" 
                 alt="service icon"
                 onerror="this.src='{{ asset('assets/img/about/about-bg-2-1.jpg') }}'">
        </div>
        <div class="service-content">
            @if($activeItem)
                <h2 class="service-title h4">
                    <a href="{{ route('service-details') }}">
                        {{ $activeItem['title'] ?? 'Service Title' }}
                    </a>
                </h2>
                
                {{-- ✅ Fixed: Render HTML properly --}}
                <p class="service-text">
                    {!! $activeItem['description'] ?? 'No description available.' !!}
                </p>
                
                <a class="link-btn" href="{{ route('services') }}">Read More</a>
            @endif
        </div>
    </div>
</div>

                    {{-- Main Image --}}
                    <div class="col-lg-5">
                        <div class="service-img">
                            <img src="{{ $mainImageUrl }}" 
                                 alt="service image"
                                 onerror="this.src='{{ asset('assets/img/bg/service-img-1.jpg') }}'">
                        </div>
                    </div>

                </div>
            </div>
        @else
            <div class="hero-content text-center">
                <h1 class="hero-title">Welcome to Our Site</h1>
                <p class="hero-text">No services available at the moment.</p>
            </div>
        @endif
    </div>
</section>