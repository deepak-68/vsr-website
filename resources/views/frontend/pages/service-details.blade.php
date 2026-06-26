@extends('frontend.layout.master')
@section('content')

<!--==============================
    Breadcumb
    ============================== -->
    <div class="breadcumb-wrapper " data-bg-src="assets/img/breadcrumb/breadcrumb.png">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Service Details</h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Service Details</li>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
     Service-details Area
    ============================== -->
    <section class="service-details space-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="service-content">
                        <h2 class="service-title h1">Gosberton Bank Nursery</h2>
                        <p class="service-text">Lorem ipsum dolor sit amet, porro quisquam est, qui dolorem ipsuquia dolor sit amet, consectetur, adipisci velit. Lorem ipsum dolor sit amet, porro quisqua
                            m est, qui dolorem ipsuquia dolor sit amet, consectetur, adipisci velit. Lorem ipsum dolor sit amet, porro quisquam est, qui dolorem ipsuquia dolor sit amet,
                            consectetur, adipisci velit. Lorem ipsum dolor sit amet, porro quisquam est, qui dolorem ipsuquia dolor sit amet, consectetur, adipisci velit. Lorem ipsum dol
                            or sit amet, porro quisquam est, qui dolorem ipsuquia dolor sit amet, consectetur, adipisci velit.
                        </p>
                        <div class="service-img1">
                            <img src="assets/img/service/service-setails-1-1.jpg" alt="service img">
                        </div>
                        <p class="service-text">dolorem ipsuquia dolor sit amet, consectetur, adipisci velit. Lorem ipsum dolor sit amet, porro quisquam est, qui dolorem ipsuquia dolor sit amet, nsectetu
                            consectetur, adipisci velit. Lorem ipsum dolor sit amet, porro quisquam est, qui dolorem ipsuquia dolor sit amet, consectetur, adipisci velit. Lorem ipsum dol
                            or sit amet, porro quisquam est, qui dolorem ipsuquia dolor sit amet, consectetur, adipisci velit.
                        </p>
                        <h4 class="service-title">Causes of Water Losses</h4>
                        <p class="service-text">dolorem ipsuquia dolor sit amet, consectetur, adipisci velit. Lorem ipsum dolor sit amet, porro quisquam est, qui dolorem.</p>
                        <div class="list-style1">
                            <ul class="list-unstyled">
                                <li><span class="icon"><img src="assets/img/icon/list-icon.png" alt="icon"></span>Before you can dive-in to creating an effective user experience</li>
                                <li><span class="icon"><img src="assets/img/icon/list-icon.png" alt="icon"></span>intuitive user experience for your users online.</li>
                                <li><span class="icon"><img src="assets/img/icon/list-icon.png" alt="icon"></span>Videos within it, each element influences</li>
                                <li><span class="icon"><img src="assets/img/icon/list-icon.png" alt="icon"></span>By providing an engaging user experience</li>
                                <li><span class="icon"><img src="assets/img/icon/list-icon.png" alt="icon"></span>Chances of converting your website visitors online.</li>
                                <li><span class="icon"><img src="assets/img/icon/list-icon.png" alt="icon"></span>From the overarching goal of your website, to the images and videos</li>
                            </ul>
                        </div>
                        <div class="row mt-30">
                            <div class="col-md-6 mb-30"><img src="assets/img/service/service-setails-1-2.jpg" alt="service-details"></div>
                            <div class="col-md-6 mb-30"><img src="assets/img/service/service-setails-1-3.jpg" alt="service-details"></div>
                        </div>
                        <h4 class="service-title">Process of Watercourse Improvement</h4>
                        <p class="service-text">dolorem ipsuquia dolor sit amet, consectetur, adipisci velit. Lorem ipsum dolor sit amet, porro quisquam est, qui dolorem.</p>
                        <div class="list-style2">
                            <ul class="list-unstyled">
                                <li>Before you can dive-in to creating an effective user experience</li>
                                <li>intuitive user experience for your users online.</li>
                                <li>Videos within it, each element influences</li>
                                <li>By providing an engaging user experience</li>
                                <li>Chances of converting your website visitors online.</li>
                                <li>From the overarching goal of your website, to the images and videos</li>
                            </ul>
                        </div>
                        <h4 class="service-title">Procedure for getting the facility</h4>
                        <p class="service-text">orem ipsum dolor sit amet, porro quisquam est, qui dolorem ipsuquia dolor sit amet, consectetur, adipisci velit. Lorem ipsum dolor sit amet, porro quisqua
                            m est, qui dolorem ipsuquia dolor sit amet, consectetur, adipisci velit. Lorem ipsum dolor sit amet, porro quisquam est, qui dolorem ipsuquia dolor sit amet,
                            consectetur, adipisci velit. Lorem ipsum dolor sit amet, porro quisquam
                        </p>
                        <div class="share-links clearfix mb-0">
                            <div class="row justify-content-between">
                                <div class="col-xl-auto">
                                    <span class="share-links-title">Tags:</span>
                                    <div class="tagcloud">
                                        <a href="{{ route('blogs') }}">Microgreen</a>
                                        <a href="{{ route('blogs') }}">farming</a>
                                        <a href="{{ route('blogs') }}">Uncategorized</a>
                                    </div>
                                </div>
                                <div class="col-xl-auto text-xl-end">
                                    <span class="share-links-title">Share:</span>
                                    <ul class="social-links">
                                        <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection