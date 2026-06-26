<!--==============================
    Team Area
============================== -->
<section class="team-layout2 space">
    <div class="container">
        <div class="title-area text-center wow fadeInUp wow-animated" data-wow-delay="0.3s">
            <div class="title-img">
                <img src="assets/img/icon/title-logo.png" alt="title logo">
            </div>
            <span class="sec-subtitle">Meet Our Experts</span>
            {{-- <h2 class="sec-title">Qualified Formers</h2> --}}
            <p>A dedicated team of professionals passionate about wellness, working together to create safe, effective, and reliable solutions you can trust.
</p>
        </div>
        
        @if(isset($team) && count($team) > 0)
        <div class="row vs-carousel" data-slide-show="3" data-lg-slide-show="3" data-md-slide-show="2" data-autoplay="true" data-arrows="true" data-dots="false" data-center-mode="true">
            @foreach($team as $member)
            <div class="col-lg-4">
                <div class="team-style2">
                    <div class="team-img">
                    
                        <img src="{{ !empty($member['image']) 
                                ? env('BACKEND_URL') . '/uploads/' . $member['image'] 
                                : asset('assets/img/team/team-2-1.jpg') }}" 
                             alt="{{ $member['fullname'] }}"
                             onerror="this.src='assets/img/team/team-2-1.jpg'">
                    </div>
                    <div class="team-content">
                        <div class="team-dsc">
                            <h4 class="team-name">
                                <a href="team-details.html">{{ $member['fullname'] }}</a>
                            </h4>
                            <span class="team-degi">{{ $member['designation'] ?? 'Team Member' }}</span>
                            @if(isset($member['phone']))
                            <a href="tel:{{ $member['phone'] }}" class="team-contact">{{ $member['phone'] }}</a>
                            @endif
                        </div>
                        <div class="social-style1">
                            @if(!empty($member['facebook']))
                            <a href="{{ $member['facebook'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            @if(!empty($member['linkedin']))
                            <a href="{{ $member['linkedin'] }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            @endif
                            @if(!empty($member['instagram']))
                            <a href="{{ $member['instagram'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                            @endif
                            @if(!empty($member['twitter']))
                            <a href="{{ $member['twitter'] }}" target="_blank"><i class="fab fa-twitter"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Fallback: Show default static content if no team data -->
        <div class="row vs-carousel" data-slide-show="3" data-lg-slide-show="3" data-md-slide-show="2" data-autoplay="true" data-arrows="true" data-dots="false" data-center-mode="true">
            <div class="col-lg-4">
                <div class="team-style2">
                    <div class="team-img">
                        <img src="assets/img/team/team-2-1.jpg" alt="team img">
                    </div>
                    <div class="team-content">
                        <div class="team-dsc">
                            <h4 class="team-name"><a href="team-details.html">Porla Romin</a></h4>
                            <span class="team-degi">Head of Farmer</span>
                            <a href="#" class="team-contact">+88 013 00 44 51</a>
                        </div>
                        <div class="social-style1">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="shape-mockup moving z-index-n1 d-none d-xl-block" style="right: 0%; top: 40%;">
        <img src="assets/img/shep/testmonial-shep-1.png" alt="shapes">
    </div>
</section>