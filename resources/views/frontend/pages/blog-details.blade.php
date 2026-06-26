@extends('frontend.layout.master')
@section('content')
<!--==============================
    Breadcumb
    ============================== -->
<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/img/breadcrumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ $blog['title'] ?? 'Blog Details' }}</h1>
        </div>
        <div class="breadcumb-menu-wrap">
            <ul class="breadcumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('blogs') }}">Blogs</a></li>
                <li>{{ \Str::limit($blog['title'] ?? 'Details', 20) }}</li>
            </ul>
        </div>
    </div>
</div>

<!--==============================
    Blog Details Area
    ==============================-->
<section class="vs-blog-wrapper blog-details space-top space-extra-bottom">
    <div class="container">
        <div class="row gx-60">
            <div class="col-lg-8">
                <div class="vs-blog">
                    <div class="blog-content">
                        
                        {{-- Blog Image --}}
                        <div class="mb-30">
                            @if(!empty($blog['image']))
                            <img src="{{ $blog['image'] ? env('BACKEND_URL') . '/storage/' . $blog['image'] : asset('assets/img/product/product-1-1.png') }}"
                                alt="product">
                                {{-- <img src="{{ env('BACKRND_URL', '') }}/blogs/{{ $blog['image'] }}" 
                                     alt="{{ $blog['title'] ?? 'Blog Image' }}"
                                     onerror="this.src='{{ asset('assets/img/blog/blog-d-1-1.jpg') }}'"> --}}
                            @else
                                <img src="{{ asset('assets/img/blog/blog-d-1-1.jpg') }}" alt="Blog Image">
                            @endif
                        </div>
                        
                        {{-- Category --}}
                        <div class="blog-meta">
                            <a href="#">
                                <i class="fal fa-tag"></i>
                                {{ !empty($blog['category']) ? $blog['category'] : 'Uncategorized' }}
                            </a>
                        </div>
                        
                        {{-- Title --}}
                        <h2 class="blog-title">{{ $blog['title'] ?? 'Blog Title' }}</h2>
                        
                        {{-- Author & Date --}}
                        <div class="blog-meta mb-4">
                            <span class="blog-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ !empty($blog['published_at']) ? \Carbon\Carbon::parse($blog['published_at'])->format('M d, Y') : 'N/A' }}
                            </span>
                            <span class="blog-date ms-3">
                                <i class="far fa-user"></i>
                                {{ $blog['author'] ?? 'Admin' }}
                            </span>
                        </div>
                        
                        {{-- Description/Content --}}
                        {{-- ✅ CORRECT - Renders HTML properly --}}
<div class="blog-text" align="justify">
    {!! !empty($blog['description']) ? $blog['description'] : 'No content available.' !!}
</div>
                        
                        {{-- Optional: Render HTML if API sends sanitized HTML --}}
                        {{-- {!! $blog['content_html'] ?? '' !!} --}}
                        
                    </div>
                    
                 
                   
                    
                </div>
            </div>
            
            {{-- Sidebar --}}
            <div class="col-lg-4">
                <aside class="sidebar-area">
                    
                    {{-- Recent Posts --}}
                    <div class="widget">
                        <h3 class="widget_title">Recent Posts</h3>
                        <div class="recent-post-wrap">
                            @forelse($recentBlogs ?? [] as $recent)
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="{{ route('blog-details', $recent['slug']) }}">
                                            <img src="{{ env('BACKRND_URL', '') }}/uploads/{{ $recent['image'] ?? '' }}" 
                                                 alt="{{ $recent['title'] ?? '' }}"
                                                 onerror="this.src='{{ asset('assets/img/blog/recent-post-1-1.jpg') }}'">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="recent-post-meta">
                                            <a href="{{ route('blogs') }}">
                                                {{ !empty($recent['published_at']) ? \Carbon\Carbon::parse($recent['published_at'])->format('M d, Y') : '' }}
                                            </a>
                                        </div>
                                        <h4 class="post-title">
                                            <a class="text-inherit" href="{{ route('blog-details', $recent['slug']) }}">
                                                {{ \Str::limit($recent['title'] ?? 'Recent Post', 40) }}
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No recent posts found.</p>
                            @endforelse
                        </div>
                    </div>
                    
                    {{-- Categories --}}
                    <div class="widget widget_categories">
                        <h3 class="widget_title">Categories</h3>
                        <ul>
                            @forelse($categories ?? [] as $category)
                                @php
                                    // Count blogs in this category
                                    $count = collect($allBlogs ?? [])
                                        ->filter(function($blog) use ($category) {
                                            return in_array((string) $category['id'], array_map('strval', $blog['category_ids'] ?? []));
                                        })
                                        ->count();
                                @endphp
                                <li>
                                    <a href="{{ route('blogs', ['category' => $category['id']]) }}">
                                        {{ $category['name'] ?? 'Uncategorized' }}
                                    </a>
                                    <span>{{ $count }}</span>
                                </li>
                            @empty
                                <li><a href="{{ route('blogs') }}">Agriculture</a><span>12</span></li>
                                <li><a href="{{ route('blogs') }}">Farming</a><span>8</span></li>
                            @endforelse
                        </ul>
                    </div>
                    
                   
                    
                </aside>
            </div>
        </div>
    </div>
</section>


@endsection