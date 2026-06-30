<!--==============================
    Counter Area
    ============================== -->
<section class="counter-layout2 space" data-bg-src="assets/img/bg/counter.png">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-7">
                <div class="title-area text-left wow fadeInUp wow-animated" data-wow-delay="0.3s">
                    <span class="sec-subtitle mb-0 text-theme">Why Choose VSR Wellness</span>
                    <h2 class="sec-title">Thoughtfully crafted for your everyday well-being.</h2>
                    <p class="title-text">Employing finest materials, trusted recipes, and uncompromising quality requirements, VSR Wellness is your source of inspiration for a healthy lifestyle that lasts not just a day but a lifetime.</p>
                </div>
            </div>
            {{-- <div class="col-lg-5">
                <div class="counter-img">
                    <img src="assets/img/bg/counter-bg2.png" alt="">
                </div>
            </div> --}}
        </div>
        
        <div class="counter-style2">
            <div class="row z-index-common g-5 justify-content-lg-between justify-content-center align-items-center">
                
                @php
                    // Extract counters from nested API structure
                    $counterItems = [];
                    
                    if (!empty($counters) && is_array($counters)) {
                        foreach ($counters as $section) {
                            // Your API: counters[0]['counters'] contains the actual items
                            if (isset($section['counters']) && is_array($section['counters'])) {
                                $counterItems = $section['counters'];
                                break;
                            }
                        }
                    }
                    
                    // Limit to 4 counters
                    $counterItems = array_slice($counterItems, 0, 4);
                    
                    // Default icons fallback
                    $defaultIcons = [
                        'assets/img/icon/counter-icon-2-1.png',
                        'assets/img/icon/counter-icon-2-2.png', 
                        'assets/img/icon/counter-icon-2-3.png',
                        'assets/img/icon/counter-icon-2-4.png'
                    ];
                @endphp
                
                @forelse($counterItems as $index => $counter)
                    <div class="col-xl-auto col-lg-4 col-md-6">
                        <div class="media-style">
                            <div class="media-inner">
                                <div class="media-icon">
                                    <div class="icon">
                                        {{-- Icon is null in API, use fallback --}}
                                        <img src="{{ $defaultIcons[$index] ?? 'assets/img/icon/counter-icon-2-1.png' }}" alt="counter-icon">
                                    </div>
                                </div>
                                <div class="media-counter">
                                    <div class="media-count">
                                        {{-- API uses 'number' not 'value' --}}
                                        <h2 class="media-title counter-number" data-count="{{ (int)($counter['number'] ?? 0) }}">00</h2>
                                        @if(!empty($counter['suffix']))
                                            <span class="media-count_icon">
                                                <i class="far fa-{{ $counter['suffix'] === '%' ? 'percent' : 'plus' }}"></i>
                                            </span>
                                        @endif
                                    </div>
                                    {{-- API uses 'label' not 'title' --}}
                                    <p class="media-text">{{ $counter['label'] ?? 'Counter Title' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Fallback static counters --}}
                    <div class="col-xl-auto col-lg-4 col-md-6">
                        <div class="media-style">
                            <div class="media-inner">
                                <div class="media-icon">
                                    <div class="icon">
                                        <img src="assets/img/icon/counter-icon-2-1.png" alt="counter-icon">
                                    </div>
                                </div>
                                <div class="media-counter">
                                    <div class="media-count">
                                        <h2 class="media-title counter-number" data-count="3145">00</h2>
                                        <span class="media-count_icon"><i class="far fa-plus"></i></span>
                                    </div>
                                    <p class="media-text">Organic Products</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-auto col-lg-4 col-md-6">
                        <div class="media-style">
                            <div class="media-inner">
                                <div class="media-icon">
                                    <div class="icon">
                                        <img src="assets/img/icon/counter-icon-2-2.png" alt="counter-icon">
                                    </div>
                                </div>
                                <div class="media-counter">
                                    <div class="media-count">
                                        <h2 class="media-title counter-number" data-count="100">00</h2>
                                        <span class="media-count_icon"><i class="far fa-percent"></i></span>
                                    </div>
                                    <p class="media-text">Organic Guaranteed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-auto col-lg-4 col-md-6">
                        <div class="media-style">
                            <div class="media-inner">
                                <div class="media-icon">
                                    <div class="icon">
                                        <img src="assets/img/icon/counter-icon-2-3.png" alt="counter-icon">
                                    </div>
                                </div>
                                <div class="media-counter">
                                    <div class="media-count">
                                        <h2 class="media-title counter-number" data-count="160">00</h2>
                                        <span class="media-count_icon"><i class="far fa-plus"></i></span>
                                    </div>
                                    <p class="media-text">Qualified Farmers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-auto col-lg-4 col-md-6">
                        <div class="media-style">
                            <div class="media-inner">
                                <div class="media-icon">
                                    <div class="icon">
                                        <img src="assets/img/icon/counter-icon-2-4.png" alt="counter-icon">
                                    </div>
                                </div>
                                <div class="media-counter">
                                    <div class="media-count">
                                        <h2 class="media-title counter-number" data-count="310">00</h2>
                                        <span class="media-count_icon"><i class="far fa-plus"></i></span>
                                    </div>
                                    <p class="media-text">Agriculture Firm</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
                
            </div>
        </div>
    </div>
</section>