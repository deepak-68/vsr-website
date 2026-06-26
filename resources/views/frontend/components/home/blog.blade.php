<!--==============================
    Blog Area
    ============================== -->
<section class="blog-layout1 space">
    <div class="container">
        <div class="title-area text-center wow fadeInUp wow-animated" data-wow-delay="0.3s">
            <div class="title-img">
                <img src="assets/img/icon/title-logo.png" alt="title logo">
            </div>
            <span class="sec-subtitle">Recent Blogs </span>
            <h2 class="sec-title">Explore Ideas That Inspire Healthy Living</h2>
        </div>
        
        <div class="row vs-carousel" data-slide-show="3" data-lg-slide-show="3" data-md-slide-show="2" data-autoplay="true" data-arrows="true">
            
            {{-- ✅ Dynamic Blogs Loop --}}
            @forelse(array_slice($blogs ?? [], 0, 4) as $blog)
            @php
                // Map category_ids to category names
                $categoryIds = $blog['category_ids'] ?? [];
                $categoryNames = [];
                
                if (!empty($categoryIds) && !empty($blogCategories)) {
                    foreach ($categoryIds as $catId) {
                        $category = collect($blogCategories)->firstWhere('id', (int) $catId);
                        if ($category) {
                            $categoryNames[] = $category['name'];
                        }
                    }
                }
                $categoryDisplay = !empty($categoryNames) 
                    ? strtoupper(implode(', ', $categoryNames)) 
                    : 'UNCATEGORIZED';
                
                // Build image URL - API returns "blogs/filename.png"
                $imageUrl = !empty($blog['image']) 
                    ? (env('BACKEND_URL', '') . '/storage/' . $blog['image'])
                    : asset('assets/img/blog/blog-img-1-1.jpg');
                
                // Format date
                $publishedDate = !empty($blog['published_at']) 
                    ? \Carbon\Carbon::parse($blog['published_at'])->format('M d, Y')
                    : 'N/A';
            @endphp
            
            <div class="col-lg-4">
                <div class="vs-blog blog-single">
                    <div class="blog-img">
                        <a href="{{ route('blog-details', $blog['slug']) }}">
                            <img src="{{ $imageUrl }}" 
                                 alt="{{ $blog['title'] ?? 'Blog Image' }}"
                                 onerror="this.src='{{ asset('assets/img/blog/blog-img-1-1.jpg') }}'">
                        </a>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <a href="{{ route('blogs', ['category' => $categoryIds[0] ?? '']) }}">
                                <i class="fal fa-tag"></i>
                                {{ $categoryDisplay }}
                            </a>
                        </div>
                        <h2 class="blog-title">
                            <a href="{{ route('blog-details', $blog['slug']) }}">
                                {{ \Str::limit($blog['title'], 50) }}
                            </a>
                        </h2>
                        <div class="blog-inner-author">
                            <img src="assets/img/blog/blog-auth-1-1.png" alt="blog author">
                            <div class="text">
                                by <a href="{{ route('blogs') }}">{{ $blog['author'] ?? 'Admin' }}</a>
                                <a href="{{ route('blogs') }}" class="blog-date">{{ $publishedDate }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                {{-- ✅ Fallback: Static Demo Blogs --}}
                <div class="col-lg-4">
                    <div class="vs-blog blog-single">
                        <div class="blog-img">
                            <a href="{{ route('blog-details', 'test') }}">
                                <img src="assets/img/blog/blog-img-1-1.jpg" alt="Blog Image">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a href="#"><i class="fal fa-tag"></i>HEALTH</a>
                            </div>
                            <h2 class="blog-title">
                                <a href="{{ route('blog-details', 'test') }}">Harvest London Publishes Its First Annual Report</a>
                            </h2>
                            <div class="blog-inner-author">
                                <img src="assets/img/blog/blog-auth-1-1.png" alt="blog author">
                                <div class="text">
                                    by <a href="{{ route('blogs') }}">Jakki James</a>
                                    <a href="{{ route('blogs') }}" class="blog-date">Dec 13, 2024</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="vs-blog blog-single">
                        <div class="blog-img">
                            <a href="{{ route('blog-details', 'test') }}">
                                <img src="assets/img/blog/blog-img-1-2.jpg" alt="Blog Image">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a href="#"><i class="fal fa-tag"></i>FARMING</a>
                            </div>
                            <h2 class="blog-title">
                                <a href="{{ route('blog-details', 'test') }}">Organic Farming Techniques for Better Yield</a>
                            </h2>
                            <div class="blog-inner-author">
                                <img src="assets/img/blog/blog-auth-1-1.png" alt="blog author">
                                <div class="text">
                                    by <a href="{{ route('blogs') }}">Sarah Miller</a>
                                    <a href="{{ route('blogs') }}" class="blog-date">Jan 05, 2025</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="vs-blog blog-single">
                        <div class="blog-img">
                            <a href="{{ route('blog-details', 'test') }}">
                                <img src="assets/img/blog/blog-img-1-3.jpg" alt="Blog Image">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a href="#"><i class="fal fa-tag"></i>AGRICULTURE</a>
                            </div>
                            <h2 class="blog-title">
                                <a href="{{ route('blog-details', 'test') }}">Sustainable Agriculture: The Future of Farming</a>
                            </h2>
                            <div class="blog-inner-author">
                                <img src="assets/img/blog/blog-auth-1-1.png" alt="blog author">
                                <div class="text">
                                    by <a href="{{ route('blogs') }}">John Doe</a>
                                    <a href="{{ route('blogs') }}" class="blog-date">Feb 18, 2025</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
            
        </div>
        
        <div class="blog-btn">
            <a href="{{ route('blogs') }}" class="vs-btn">View All News</a>
        </div>
    </div>
</section>