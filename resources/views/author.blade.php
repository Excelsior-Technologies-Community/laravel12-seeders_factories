@extends('layouts.app')

@section('title', $author->name . ' - Author')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <img src="{{ $author->avatar }}" alt="{{ $author->name }}" 
                         class="rounded-circle me-4" width="100" height="100">
                    <div>
                        <h1 class="card-title mb-2">{{ $author->name }}</h1>
                        @if($author->role)
                        <span class="badge bg-primary mb-3">{{ ucfirst($author->role) }}</span>
                        @endif
                        @if($author->bio)
                        <p class="card-text">{{ $author->bio }}</p>
                        @endif
                        <div class="mt-3">
                            <span class="me-4"><strong>Posts:</strong> {{ $author->posts()->published()->count() }}</span>
                            <span class="me-4"><strong>Comments:</strong> {{ $author->comments()->count() }}</span>
                            <span><strong>Joined:</strong> {{ $author->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mb-4">Latest Posts by {{ $author->name }}</h3>

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
                                    {{ $post->created_at->format('M d, Y') }}
                                    <span class="mx-2">•</span>
                                    {{ $post->views }} views
                                    <span class="mx-2">•</span>
                                    {{ $post->comments()->count() }} comments
                                </div>
                                <div>
                                    @foreach($post->categories->take(2) as $category)
                                    <span class="badge bg-secondary me-1">{{ $category->name }}</span>
                                    @endforeach
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
                <h4>No posts found by this author</h4>
                <p>This author hasn't published any posts yet.</p>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Author Stats</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><strong>Total Posts:</strong> {{ $author->posts()->count() }}</li>
                    <li class="mb-2"><strong>Published Posts:</strong> {{ $author->posts()->published()->count() }}</li>
                    <li class="mb-2"><strong>Draft Posts:</strong> {{ $author->posts()->draft()->count() }}</li>
                    <li class="mb-2"><strong>Total Comments:</strong> {{ $author->comments()->count() }}</li>
                    <li><strong>Email:</strong> {{ $author->email }}</li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Most Popular Post</h5>
            </div>
            <div class="card-body">
                @php
                    $popularPost = $author->posts()
                        ->published()
                        ->orderBy('views', 'desc')
                        ->first();
                @endphp
                
                @if($popularPost)
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
                    <p class="mt-2 mb-0 small">{{ Str::limit($popularPost->excerpt, 100) }}</p>
                </div>
                @else
                <p class="text-muted mb-0">No popular posts yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection