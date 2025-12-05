@extends('layouts.app')

@section('title', $category->name . ' - Category')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="mb-4">
            <h1 class="display-5">{{ $category->name }}</h1>
            @if($category->description)
            <p class="lead">{{ $category->description }}</p>
            @endif
            
            @if($category->parent)
            <div class="alert alert-info">
                Parent Category: 
                <a href="/category/{{ $category->parent->slug }}" class="text-decoration-none">
                    {{ $category->parent->name }}
                </a>
            </div>
            @endif
            
            @if($category->children->count() > 0)
            <div class="mb-4">
                <h5>Subcategories:</h5>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($category->children as $subcategory)
                    <a href="/category/{{ $subcategory->slug }}" class="badge bg-secondary text-decoration-none">
                        {{ $subcategory->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        @if($posts->count() > 0)
            @foreach($posts as $post)
            <div class="card mb-4 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ $post->featured_image }}" class="img-fluid rounded-start h-100" alt="{{ $post->title }}">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="/post/{{ $post->slug }}" class="text-decoration-none text-dark">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            <p class="card-text">{{ Str::limit($post->excerpt, 150) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="post-meta">
                                    <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" 
                                         class="rounded-circle me-2" width="30" height="30">
                                    By {{ $post->user->name }}
                                    <span class="mx-2">•</span>
                                    {{ $post->created_at->format('M d, Y') }}
                                    <span class="mx-2">•</span>
                                    {{ $post->views }} views
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        @else
            <div class="alert alert-info">
                <h4>No posts found in this category</h4>
                <p>Check back later for new content!</p>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Category Info</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><strong>Posts in this category:</strong> {{ $posts->total() }}</li>
                    @if($category->parent)
                    <li class="mb-2"><strong>Parent Category:</strong> 
                        <a href="/category/{{ $category->parent->slug }}" class="text-decoration-none">
                            {{ $category->parent->name }}
                        </a>
                    </li>
                    @endif
                    @if($category->children->count() > 0)
                    <li class="mb-2"><strong>Subcategories:</strong> {{ $category->children->count() }}</li>
                    @endif
                    <li><strong>Created:</strong> {{ $category->created_at->format('M d, Y') }}</li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Popular in {{ $category->name }}</h5>
            </div>
            <div class="card-body">
                @php
                    $popularPosts = \App\Models\Post::whereHas('categories', function($query) use ($category) {
                        $query->where('categories.id', $category->id);
                    })
                    ->published()
                    ->orderBy('views', 'desc')
                    ->limit(5)
                    ->get();
                @endphp
                
                @if($popularPosts->count() > 0)
                    @foreach($popularPosts as $popularPost)
                    <div class="mb-3">
                        <h6 class="mb-1">
                            <a href="/post/{{ $popularPost->slug }}" class="text-decoration-none">
                                {{ $popularPost->title }}
                            </a>
                        </h6>
                        <small class="text-muted">
                            {{ $popularPost->views }} views • 
                            {{ $popularPost->created_at->format('M d, Y') }}
                        </small>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted mb-0">No popular posts yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection