@extends('frontend.layout.master')
@section('content')
  <!--==============================
    Breadcumb
    ============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ url('assets/img/breadcrumb/breadcrumb.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">
                    {{ $disclaimer['main_title'] ?? 'Terms & Conditions' }}
                </h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>{{ $disclaimer['sub_title'] ?? 'Terms & Conditions' }}</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="about-layout1 space-top">
        <div class="container">
            <div class="about-content">
                <div class="title-area wow fadeInUp wow-animated" data-wow-delay="0.3s">
                    <span class="sec-subtitle">
                        {{ $disclaimer['sub_title'] ?? 'Welcome to Farmix' }}
                    </span>
                    {{-- <h2 class="sec-title">
                        {{ $disclaimer['main_title'] ?? 'Terms & Conditions' }}
                    </h2> --}}
                </div>
                
                <div class="about-text">
                    @if($disclaimer && !empty($disclaimer['description']))
                        {{-- Render HTML content safely with allowed tags --}}
                        {!! strip_tags($disclaimer['description'], '<p><br><strong><em><ul><ol><li><h3><h4><a><span><div>') !!}
                    @else
                        <p class="text-muted">Terms & Conditions content is currently unavailable. Please check back later.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection