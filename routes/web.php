<?php

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $posts = Post::with(['user', 'categories'])
        ->published()
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
    $categories = Category::withCount('posts')
        ->orderBy('posts_count', 'desc')
        ->limit(10)
        ->get();
    
    return view('welcome', compact('posts', 'categories'));
});

Route::get('/post/{slug}', function ($slug) {
    $post = Post::with(['user', 'categories', 'comments.user'])
        ->where('slug', $slug)
        ->published()
        ->firstOrFail();
    
    $post->incrementViews();
    
    $relatedPosts = Post::whereHas('categories', function ($query) use ($post) {
            $query->whereIn('categories.id', $post->categories->pluck('id'));
        })
        ->where('id', '!=', $post->id)
        ->published()
        ->limit(3)
        ->get();
    
    return view('post', compact('post', 'relatedPosts'));
});

Route::get('/category/{slug}', function ($slug) {
    $category = Category::with(['parent', 'children'])
        ->where('slug', $slug)
        ->firstOrFail();
    
    $posts = $category->posts()
        ->with(['user', 'categories'])
        ->published()
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
    return view('category', compact('category', 'posts'));
});

Route::get('/author/{id}', function ($id) {
    $author = User::findOrFail($id);
    
    $posts = $author->posts()
        ->with('categories')
        ->published()
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
    return view('author', compact('author', 'posts'));
});

Route::get('/dashboard', function () {
    $stats = [
        'total_posts' => Post::count(),
        'published_posts' => Post::published()->count(),
        'total_categories' => Category::count(),
        'total_comments' => Comment::count(),
        'total_users' => User::count(),
        'recent_posts' => Post::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(),
    ];
    
    return view('dashboard', compact('stats'));
});

// Test route to verify data
Route::get('/test-data', function () {
    return response()->json([
        'users_count' => User::count(),
        'posts_count' => Post::count(),
        'categories_count' => Category::count(),
        'comments_count' => Comment::count(),
        'recent_posts' => Post::with('user')
            ->latest()
            ->limit(3)
            ->get(['id', 'title', 'user_id', 'status', 'created_at'])
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'author' => $post->user->name,
                    'status' => $post->status,
                    'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                ];
            }),
        'categories' => Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(5)
            ->get(['id', 'name', 'posts_count']),
    ]);
});