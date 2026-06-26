<!--==============================
    Brand Area
    ============================== -->
    <div class="brand-layout1">
        <div class="container">
            <div class="row vs-carousel z-index-common" data-arrows="false" data-wow-delay="0.4s" data-slide-show="6" data-lg-slide-show="6" data-md-slide-show="4" data-xs-slide-show="2" data-center-mode="true" data-autoplay="true">
                     @forelse($partners as $partner)
                    <div class="col-auto">
                        <div class="bran-img">
                        <img src="{{ $partner['image'] ?? 'assets/img/brand/brand-1.png' }}" alt="hero-img">
                            
                        </div>
                    </div>
                     @empty
            <div class="slide-img">
                <img src="assets/img/brand/brand-1.png" alt="hero-img">
            </div>
            @endforelse

                </div>
        </div>
    </div>