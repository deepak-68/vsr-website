@extends('frontend.layout.master')
@section('content')

@include('frontend.components.home.slider')
@include('frontend.components.home.about-us')
@include('frontend.components.home.categories')
@include('frontend.components.home.products')
{{-- @include('frontend.components.home.provide') --}}
@include('frontend.components.home.consult')
@include('frontend.components.home.services')
@include('frontend.components.home.counter')
@include('frontend.components.home.team')
@include('frontend.components.home.brand')
@include('frontend.components.home.blog')
{{-- 
@include('frontend.components.home.faq')
@include('frontend.components.home.testimonial') --}}


@endsection