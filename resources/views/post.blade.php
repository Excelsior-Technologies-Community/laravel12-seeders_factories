@extends('layouts.app')

@section('title', $post->title . ' - Laravel Blog')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <article>
            <header class="mb-4">
                <h1 class="fw-bold mb-3">{{ $post->title }}</h1>
                <div class="post-meta mb-3">
                    <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" 
                         class="rounded-circle me-2" width="40" height="40">
                    <span class="me-3">
                        By <strong>{{ $post->user->name }}</strong>
                    </span>
                    <span class="me-3">
                        {{ $post->created_at->format('F d, Y') }}
                    </span>
                    <span class="me-3">
                        <i class="fas fa-eye"></i> {{ $post->views }} views
                    </span>
                    <div class="mt-2">
                        @foreach($post->categories as $category)
                        <a href="/category/{{ $category->slug }}" class="badge bg-primary text-decoration-none me-1">
                            {{ $category->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </header>

            <figure class="mb-4">
                <img class="img-fluid rounded w-100" src="{{ $post->featured_image }}" alt="{{ $post->title }}">
            </figure>

            <section class="mb-5">
                {!! $post->content !!}
            </section>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">About the Author</h5>
                    <div class="d-flex align-items-center">
                        <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" 
                             class="rounded-circle me-3" width="60" height="60">
                        <div>
                            <h6>{{ $post->user->name }}</h6>
                            <p class="text-muted mb-0">{{ $post->user->bio ?? 'No bio available' }}</p>
                            <a href="/author/{{ $post->user->id }}" class="btn btn-sm btn-outline-primary mt-2">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <section class="mb-5">
                <h3 class="mb-4">Comments ({{ $post->comments->where('parent_id', null)->count() }})</h3>
                
                @foreach($post->comments->where('parent_id', null) as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex">
                            <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}" 
                                 class="rounded-circle me-3" width="40" height="40">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $comment->user->name }}</h6>
                                <small class="text-muted">{{ $comment->created_at->format('M d, Y H:i') }}</small>
                                <p class="mt-2 mb-3">{{ $comment->content }}</p>
                                
                                @if($comment->replies->count() > 0)
                                <div class="ps-4 border-start">
                                    @foreach($comment->replies as $reply)
                                    <div class="mb-2">
                                        <div class="d-flex">
                                            <img src="{{ $reply->user->avatar }}" alt="{{ $reply->user->name }}" 
                                                 class="rounded-circle me-2" width="30" height="30">
                                            <div>
                                                <small><strong>{{ $reply->user->name }}</strong></small>
                                                <small class="text-muted ms-2">{{ $reply->created_at->format('M d, Y H:i') }}</small>
                                                <p class="mt-1 mb-0">{{ $reply->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @if($post->comments->count() === 0)
                <div class="alert alert-info">
                    No comments yet. Be the first to comment!
                </div>
                @endif
            </section>
        </article>
    </div>

    <div class="col-lg-4">
        @if($relatedPosts->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Related Posts</h5>
            </div>
            <div class="card-body">
                @foreach($relatedPosts as $relatedPost)
                <div class="mb-3">
                    <h6 class="mb-1">
                        <a href="/post/{{ $relatedPost->slug }}" class="text-decoration-none">
                            {{ $relatedPost->title }}
                        </a>
                    </h6>
                    <small class="text-muted">
                        {{ $relatedPost->created_at->format('M d, Y') }}
                    </small>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Share This Post</h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm flex-fill">
                        <i class="fab fa-twitter"></i> Twitter
                    </button>
                    <button class="btn btn-outline-primary btn-sm flex-fill">
                        <i class="fab fa-facebook"></i> Facebook
                    </button>
                    <button class="btn btn-outline-primary btn-sm flex-fill">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Post loaded: {{ $post->title }}');
    });
</script>
@endpush