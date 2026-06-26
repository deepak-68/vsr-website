@extends('frontend.layout.master')
@section('content')
<!--==============================
    Breadcumb
    ============================== -->
<div class="breadcumb-wrapper" data-bg-src="assets/img/breadcrumb/breadcrumb.png">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Our Blogs</h1>
        </div>
        <div class="breadcumb-menu-wrap">
            <ul class="breadcumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Our Blogs</li>
            </ul>
        </div>
    </div>
</div>

<!--==============================
    Blog Area
    ==============================-->
<section class="vs-blog-wrapper space-top space-extra-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                
                {{-- ✅ Dynamic Blogs Loop --}}
                @forelse($blogs ?? [] as $blog)
                @php
                    // Map category IDs to names
                    $categoryIds = $blog['category_ids'] ?? [];
                    $categoryNames = [];
                    
                    if (!empty($categoryIds) && !empty($categories)) {
                        foreach ($categoryIds as $catId) {
                            $category = collect($categories)->firstWhere('id', (int) $catId);
                            if ($category) {
                                $categoryNames[] = $category['name'];
                            }
                        }
                    }
                    $categoryDisplay = !empty($categoryNames) 
                        ? strtoupper(implode(', ', $categoryNames)) 
                        : 'UNCATEGORIZED';
                    
                    // Build image URL
                    $imageUrl = !empty($blog['image']) 
                        ? (env('BACKEND_URL', '') . '/storage/' . $blog['image'])
                        : asset('assets/img/blog/blog-s-1-1.png');
                @endphp
                
                <div class="vs-blog blog-single">
                    @if(!empty($blog['image']))
                    <div class="blog-img">
                        <a href="{{ route('blog-details', $blog['slug']) }}">
                            <img src="{{ $imageUrl }}" 
                                 alt="{{ $blog['title'] ?? 'Blog Image' }}"
                                 onerror="this.src='{{ asset('assets/img/blog/blog-s-1-1.png') }}'">
                        </a>
                    </div>
                    @endif
                    
                    <div class="blog-content">
                        <div class="blog-meta">
                            <a href="{{ route('blogs', ['category' => $categoryIds[0] ?? '']) }}">
                                <i class="fal fa-tag"></i>
                                {{ $categoryDisplay }}
                            </a>
                        </div>
                        <h2 class="blog-title">
                            <a href="{{ route('blog-details', $blog['slug']) }}">
                                {{ \Str::limit($blog['title'], 60) }}
                            </a>
                        </h2>
                        <p class="blog-text">
                            {{ \Str::limit(strip_tags($blog['description']), 150) }}
                        </p>
                        <div class="blog-inner-author">
                            @if(!empty($blog['author_image']))
                                <img src="{{ env('BACKEND_URL', '') }}/storage/{{ $blog['author_image'] }}" alt="blog author">
                            @else
                                <img src="assets/img/blog/blog-auth-1-1.png" alt="blog author">
                            @endif
                            by <a href="{{ route('blogs') }}">{{ $blog['author'] ?? 'Admin' }}</a>
                            <a href="{{ route('blogs') }}" class="blog-date">
                                {{ \Carbon\Carbon::parse($blog['published_at'])->format('M d, Y') }}
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                    {{-- No blogs found --}}
                    <div class="text-center py-5">
                        <img src="{{ asset('assets/img/empty-state.png') }}" alt="No blogs" style="max-width: 200px;">
                        <h4 class="mt-3">No blogs found</h4>
                        <p class="text-muted">Check back later for new articles.</p>
                    </div>
                @endforelse
                
                {{-- ✅ Pagination --}}
                @if(($pagination['total'] ?? 0) > ($pagination['per_page'] ?? 6))
                <div class="vs-pagination">
                    <ul>
                        {{-- Previous --}}
                        <li class="arrow {{ $pagination['current_page'] == 1 ? 'disabled' : '' }}">
                            @if($pagination['current_page'] > 1)
                                <a href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] - 1]) }}">
                                    <i class="fal fa-long-arrow-left"></i>
                                </a>
                            @else
                                <span><i class="fal fa-long-arrow-left"></i></span>
                            @endif
                        </li>
                        
                        {{-- Page Numbers --}}
                        @for($i = 1; $i <= $pagination['last_page']; $i++)
                            @if($i == 1 || $i == $pagination['last_page'] || ($i >= $pagination['current_page'] - 1 && $i <= $pagination['current_page'] + 1))
                                <li class="{{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                    <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                </li>
                            @elseif($i == $pagination['current_page'] - 2 || $i == $pagination['current_page'] + 2)
                                <li><span>...</span></li>
                            @endif
                        @endfor
                        
                        {{-- Next --}}
                        <li class="arrow {{ $pagination['current_page'] == $pagination['last_page'] ? 'disabled' : '' }}">
                            @if($pagination['current_page'] < $pagination['last_page'])
                                <a href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] + 1]) }}">
                                    <i class="fal fa-long-arrow-right"></i>
                                </a>
                            @else
                                <span><i class="fal fa-long-arrow-right"></i></span>
                            @endif
                        </li>
                    </ul>
                </div>
                @endif
                
            </div>
            
            {{-- Sidebar --}}
            <div class="col-lg-4">
                <aside class="sidebar-area">
                    
                    {{-- Search Widget --}}
                    <div class="widget">
                        <form action="{{ route('blogs') }}" method="GET" class="search-form">
                            <input type="text" name="search" placeholder="Search blogs..." 
                                   value="{{ request('search') }}" class="form-control">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                    
                    {{-- Recent Posts --}}
                    <div class="widget">
                        <h3 class="widget_title">Recent Posts</h3>
                        <div class="recent-post-wrap">
                            @forelse(array_slice($allBlogs ?? [], 0, 3) as $recent)
                                @php
                                    $recentImg = !empty($recent['image']) 
                                        ? env('BACKEND_URL', '') . '/storage/' . $recent['image']
                                        : asset('assets/img/blog/recent-post-1-1.jpg');
                                @endphp
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="{{ route('blog-details', $recent['slug']) }}">
                                            <img src="{{ $recentImg }}" 
                                                 alt="{{ $recent['title'] ?? '' }}"
                                                 onerror="this.src='{{ asset('assets/img/blog/recent-post-1-1.jpg') }}'">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="recent-post-meta">
                                            <a href="{{ route('blogs') }}">
                                                {{ \Carbon\Carbon::parse($recent['published_at'])->format('M d, Y') }}
                                            </a>
                                        </div>
                                        <h4 class="post-title">
                                            <a class="text-inherit" href="{{ route('blog-details', $recent['slug']) }}">
                                                {{ \Str::limit($recent['title'], 40) }}
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No recent posts.</p>
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
                            @endforelse
                        </ul>
                    </div>
                    
                   
                    
                   
                    
                </aside>
            </div>
        </div>
    </div>
</section>


@endsection