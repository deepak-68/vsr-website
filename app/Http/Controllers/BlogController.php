<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private function getApiUrl()
    {
        return config('api.base_url');
    }

    /**
     * Display all blogs page with pagination
     */
    public function index(Request $request)
    {
        try {
            // Fetch blogs from API
            $response = Http::timeout(15)->get($this->getApiUrl() . '/blogs');
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Get blogs and categories from API response
                $allBlogs = $data['blogs'] ?? $data['data'] ?? [];
                $categories = $data['blog_category'] ?? $data['categories'] ?? [];
                
                // Filter by category if requested
                $categoryId = $request->query('category');
                if ($categoryId) {
                    $allBlogs = collect($allBlogs)
                        ->filter(function($blog) use ($categoryId) {
                            $blogCats = $blog['category_ids'] ?? [];
                            return in_array((string) $categoryId, array_map('strval', $blogCats));
                        })
                        ->toArray();
                }
                
                // Filter by tag if requested
                $tag = $request->query('tag');
                if ($tag) {
                    $allBlogs = collect($allBlogs)
                        ->filter(function($blog) use ($tag) {
                            $blogTags = $blog['tags'] ?? [];
                            return in_array($tag, $blogTags);
                        })
                        ->toArray();
                }
                
                // Search functionality
                $search = $request->query('search');
                if ($search) {
                    $allBlogs = collect($allBlogs)
                        ->filter(function($blog) use ($search) {
                            $searchLower = strtolower($search);
                            return stripos($blog['title'] ?? '', $searchLower) !== false 
                                || stripos($blog['description'] ?? '', $searchLower) !== false;
                        })
                        ->toArray();
                }
                
                // Manual pagination (since API might not support it)
                $perPage = 6;
                $currentPage = $request->get('page', 1);
                $paginatedBlogs = collect($allBlogs)
                    ->forPage($currentPage, $perPage)
                    ->values()
                    ->all();
                
                return view('frontend.pages.blogs', [
                    'blogs' => $paginatedBlogs,
                    'allBlogs' => $allBlogs,
                    'categories' => $categories,
                    'pagination' => [
                        'current_page' => $currentPage,
                        'per_page' => $perPage,
                        'total' => count($allBlogs),
                        'last_page' => ceil(count($allBlogs) / $perPage),
                    ],
                    'filters' => [
                        'category' => $categoryId,
                        'tag' => $tag,
                        'search' => $search,
                    ]
                ]);
            }
            
            Log::error('Failed to fetch blogs', [
                'status' => $response->status(),
                'url' => $this->getApiUrl() . '/blogs'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Blogs Page API Error: ' . $e->getMessage());
        }
        
        // Return empty state on error
        return view('frontend.pages.blogs', [
            'blogs' => [],
            'allBlogs' => [],
            'categories' => [],
            'pagination' => ['current_page' => 1, 'per_page' => 6, 'total' => 0, 'last_page' => 1],
            'filters' => []
        ]);
    }

    /**
     * Display single blog details
     */
    public function show($slug)
    {
        try {
            $response = Http::timeout(10)->get($this->getApiUrl() . '/blogs');
            
            if ($response->successful()) {
                $data = $response->json();
                $blogs = $data['blogs'] ?? $data['data'] ?? [];
                $categories = $data['blog_category'] ?? $data['categories'] ?? [];
                
                // Find blog by slug
                $blog = collect($blogs)->firstWhere('slug', $slug);
                
                if (!$blog) {
                    abort(404, 'Blog not found');
                }
                
                // Map category IDs to names
                $categoryIds = $blog['category_ids'] ?? [];
                $categoryNames = collect($categories)
                    ->filter(function($cat) use ($categoryIds) {
                        return in_array((string) $cat['id'], array_map('strval', $categoryIds));
                    })
                    ->pluck('name')
                    ->toArray();
                
                $blog['category_name'] = !empty($categoryNames) 
                    ? implode(', ', $categoryNames) 
                    : 'Uncategorized';
                
                // Get recent blogs for sidebar (exclude current)
                $recentBlogs = collect($blogs)
                    ->filter(fn($b) => ($b['slug'] ?? '') !== $slug)
                    ->take(3)
                    ->values()
                    ->toArray();
                
                return view('frontend.pages.blog-details', [
                    'blog' => $blog,
                    'recentBlogs' => $recentBlogs,
                    'categories' => $categories,
                    'allBlogs' => $blogs
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error('Blog Details API Error: ' . $e->getMessage());
        }
        
        abort(404, 'Blog not found');
    }
}