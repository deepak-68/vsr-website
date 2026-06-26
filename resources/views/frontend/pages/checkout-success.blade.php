@extends('frontend.layout.master')

@section('content')
<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/img/breadcrumb/breadcrumb.png') }}">
    <div class="container z-index-common">
        <h1 class="breadcumb-title">Order Received</h1>
    </div>
</div>

<section class="space">
    <div class="container">
        <div class="text-center py-5">
            <i class="fas fa-check-circle text-success fa-4x mb-4"></i>
            <h2>Thank you! Your order has been received.</h2>
            
            @if(isset($order))
                <div class="order-summary mt-4 p-4 bg-light rounded">
                    <p><strong>Order Number:</strong> {{ $order['order_number'] }}</p>
                    <p><strong>Total Amount:</strong> Rs.{{ number_format($order['total'], 2) }}</p>
                    <p><strong>Payment Method:</strong> {{ ucfirst($order['payment_method']) }}</p>
                    @if(isset($order['note']))
                        <p class="text-warning"><small>{{ $order['note'] }}</small></p>
                    @endif
                </div>
            @endif
            
            <div class="mt-4">
                <a href="{{ route('products') }}" class="vs-btn me-2">Continue Shopping</a>
                <a href="{{ route('home') }}" class="vs-btn outline">Go to Home</a>
            </div>
        </div>
    </div>
</section>
@endsection