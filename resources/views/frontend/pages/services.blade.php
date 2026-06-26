@extends('frontend.layout.master')
@section('content')

  <!--==============================
    Breadcumb
    ============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{url ('assets/img/breadcrumb/breadcrumb.png')}}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Our Service</h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Our Service</li>
                </ul>
            </div>
        </div>
    </div>



     <!--==============================
    Selling Area
    ============================== -->
    <section class="selling-layout1 bg-white space-bottom">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-6">
                    <div class="selling-style1 space-top">
                        <div class="title-area wow fadeInUp wow-animated" data-wow-delay="0.3s">
                            <span class="sec-subtitle">Welcome to Farmix</span>
                            <h2 class="sec-title">Agriculture & Organic Product Farm</h2>
                        </div>
                        <div class="list-style1">
                            <ul class="list-unstyled">
                                <li><span class="icon"><i class="far fa-check-circle"></i></span>Before you can dive-in to creating an effective user experience</li>
                                <li><span class="icon"><i class="far fa-check-circle"></i></span>intuitive user experience for your users online.</li>
                                <li><span class="icon"><i class="far fa-check-circle"></i></span>Videos within it, each element influences</li>
                            </ul>
                        </div>
                        <div class="row g-3 vs-carousel" data-arrows="false" data-dots="true" data-autoplay="true" data-slide-show="2">
                            <div class="col-auto">
                                <a href="{{ route ('blog-details') }}"><img src="assets/img/blog/blog-s-1-1.png" alt="Blog Image"></a>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route ('blog-details') }}"><img src="assets/img/blog/blog-s-1-2.png" alt="Blog Image"></a>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route ('blog-details') }}"><img src="assets/img/blog/blog-s-1-3.png" alt="Blog Image"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="selling-img">
                        <img src="assets/img/service/selling-img-1-1.png" alt="selling-img">
                        <div class="img1">
                            <img src="assets/img/service/selling-img-1-2.png" alt="selling-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shape-mockup moving z-index d-none d-lg-block" style="right: 0%; bottom: 22%;"><img src="assets/img/shep/selling-shep-1.png" alt="shapes"></div>
    </section>
    <!--==============================
    Service Area
    ============================== -->


     <div class="service-layout1 space-bottom mt-0">
        <div class="container">
            <div class="row vs-carousel" data-slide-show="4" data-lg-slide-show="3" data-md-slide-show="2" data-autoplay="true" data-arrows="false">
                <div class="col-auto">
                    <div class="service-style1">
                        <div class="service-img2"><img src="assets/img/service/service-1-1.jpg" alt="service thumbnail"></div>
                        <div class="service-img"><img src="assets/img/service/service-1-1.jpg" alt="service thumbnail"></div>
                        <div class="service-inner">
                            <div class="service-icon"><img src="assets/img/icon/service-icon-1-1.png" alt="icon"></div>
                            <h3 class="service-title h5"><a href="{{ route('service-details') }}">Agriculture</a></h3>
                            <p class="service-text">Veritatis eligendi, dignissimo fermentum mus aute pulvinar platea massa rutrum.</p>
                        </div>
                        <div class="link-btn">
                            <a href="#">Read More <i class="far fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="service-style1">
                        <div class="service-img2"><img src="assets/img/service/service-1-2.jpg" alt="service thumbnail"></div>
                        <div class="service-img"><img src="assets/img/service/service-1-2.jpg" alt="service thumbnail"></div>
                        <div class="service-inner">
                            <div class="service-icon"><img src="assets/img/icon/service-icon-1-2.png" alt="icon"></div>
                            <h3 class="service-title h5"><a href="{{ route('service-details') }}">Vagatables</a></h3>
                            <p class="service-text">Veritatis eligendi, dignissimo fermentum mus aute pulvinar platea massa rutrum.</p>
                        </div>
                        <div class="link-btn">
                            <a href="#">Read More <i class="far fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="service-style1">
                        <div class="service-img2"><img src="assets/img/service/service-1-3.jpg" alt="service thumbnail"></div>
                        <div class="service-img"><img src="assets/img/service/service-1-3.jpg" alt="service thumbnail"></div>
                        <div class="service-inner">
                            <div class="service-icon"><img src="assets/img/icon/service-icon-1-3.png" alt="icon"></div>
                            <h3 class="service-title h5"><a href="{{ route('service-details') }}">Farm Factory</a></h3>
                            <p class="service-text">Veritatis eligendi, dignissimo fermentum mus aute pulvinar platea massa rutrum.</p>
                        </div>
                        <div class="link-btn">
                            <a href="#">Read More <i class="far fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="service-style1">
                        <div class="service-img2"><img src="assets/img/service/service-1-4.jpg" alt="service thumbnail"></div>
                        <div class="service-img"><img src="assets/img/service/service-1-4.jpg" alt="service thumbnail"></div>
                        <div class="service-inner">
                            <div class="service-icon"><img src="assets/img/icon/service-icon-1-4.png" alt="icon"></div>
                            <h3 class="service-title h5"><a href="{{ route('service-details') }}">Modern Technique</a></h3>
                            <p class="service-text">Veritatis eligendi, dignissimo fermentum mus aute pulvinar platea massa rutrum.</p>
                        </div>
                        <div class="link-btn">
                            <a href="#">Read More <i class="far fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="service-style1">
                        <div class="service-img2"><img src="assets/img/service/service-1-5.jpg" alt="service thumbnail"></div>
                        <div class="service-img"><img src="assets/img/service/service-1-5.jpg" alt="service thumbnail"></div>
                        <div class="service-inner">
                            <div class="service-icon"><img src="assets/img/icon/service-icon-1-1.png" alt="icon"></div>
                            <h3 class="service-title h5"><a href="{{ route('service-details') }}">Modern Technique</a></h3>
                            <p class="service-text">Veritatis eligendi, dignissimo fermentum mus aute pulvinar platea massa rutrum.</p>
                        </div>
                        <div class="link-btn">
                            <a href="#">Read More <i class="far fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


     <!--==============================
    Provide Area
    ============================== -->
    <section class="provide-layout1 space" data-bg-src="assets/img/bg/provide-bg-1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-12">
                    <div class="provide-style1">
                        <div class="title-area wow fadeInUp wow-animated" data-wow-delay="0.3s">
                            <span class="sec-subtitle">Welcome to Farmix</span>
                            <h2 class="sec-title">What We Provide</h2>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-6">
                                <div class="provide-item">
                                    <div class="provide-icon">
                                        <img src="assets/img/icon/counter-icon1.png" alt="provide icon">
                                    </div>
                                    <div class="provide-content">
                                        <h2 class="title h6"><a href="{{ route('services') }}">Quality Foods</a></h2>
                                        <p class="text">In hac habitasse platea ived ict tibulum rhonc us est.</p>
                                    </div>
                                </div>
                                <div class="provide-item">
                                    <div class="provide-icon">
                                        <img src="assets/img/icon/counter-icon2.png" alt="provide icon">
                                    </div>
                                    <div class="provide-content">
                                        <h2 class="title h6"><a href="{{ route('services') }}">All organic</a></h2>
                                        <p class="text">In hac habitasse platea ived ict tibulum rhonc us est.</p>
                                    </div>
                                </div>
                                <div class="provide-item">
                                    <div class="provide-icon">
                                        <img src="assets/img/icon/counter-icon3.png" alt="provide icon">
                                    </div>
                                    <div class="provide-content">
                                        <h2 class="title h6"><a href="{{ route('services') }}">Friendly team</a></h2>
                                        <p class="text">In hac habitasse platea ived ict tibulum rhonc us est.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="provide-item">
                                    <div class="provide-icon">
                                        <img src="assets/img/icon/counter-icon4.png" alt="provide icon">
                                    </div>
                                    <div class="provide-content">
                                        <h2 class="title h6"><a href="{{ route('services') }}">Eco friendly</a></h2>
                                        <p class="text">In hac habitasse platea ived ict tibulum rhonc us est.</p>
                                    </div>
                                </div>
                                <div class="provide-item">
                                    <div class="provide-icon">
                                        <img src="assets/img/icon/counter-icon5.png" alt="provide icon">
                                    </div>
                                    <div class="provide-content">
                                        <h2 class="title h6"><a href="{{ route('services') }}">Fresh Vegetables</a></h2>
                                        <p class="text">In hac habitasse platea ived ict tibulum rhonc us est.</p>
                                    </div>
                                </div>
                                <div class="provide-item">
                                    <div class="provide-icon">
                                        <img src="assets/img/icon/counter-icon6.png" alt="provide icon">
                                    </div>
                                    <div class="provide-content">
                                        <h2 class="title h6"><a href="{{ route('services') }}">Use Green Products</a></h2>
                                        <p class="text">In hac habitasse platea ived ict tibulum rhonc us est.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('frontend.components.home.faq')






@endsection