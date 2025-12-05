@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="display-4 mb-4">Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Posts</h6>
                            <h2 class="mb-0">{{ $stats['total_posts'] }}</h2>
                        </div>
                        <i class="fas fa-newspaper fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Published Posts</h6>
                            <h2 class="mb-0">{{ $stats['published_posts'] }}</h2>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Categories</h6>
                            <h2 class="mb-0">{{ $stats['total_categories'] }}</h2>
                        </div>
                        <i class="fas fa-tags fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Users</h6>
                            <h2 class="mb-0">{{ $stats['total_users'] }}</h2>
                        </div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Posts</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Views</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['recent_posts'] as $post)
                                <tr>
                                    <td>
                                        <a href="/post/{{ $post->slug }}" class="text-decoration-none">
                                            {{ Str::limit($post->title, 40) }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" 
                                                 class="rounded-circle me-2" width="25" height="25">
                                            {{ $post->user->name }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($post->status == 'published')
                                        <span class="badge bg-success">Published</span>
                                        @elseif($post->status == 'draft')
                                        <span class="badge bg-warning">Draft</span>
                                        @else
                                        <span class="badge bg-secondary">{{ ucfirst($post->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->views }}</td>
                                    <td>{{ $post->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <strong>Total Comments:</strong> {{ $stats['total_comments'] }}
                        </li>
                        <li class="mb-3">
                            <strong>Approved Comments:</strong> 
                            {{ \App\Models\Comment::where('is_approved', true)->count() }}
                        </li>
                        <li class="mb-3">
                            <strong>Pending Comments:</strong> 
                            {{ \App\Models\Comment::where('is_approved', false)->count() }}
                        </li>
                        <li>
                            <strong>Today's Posts:</strong> 
                            {{ \App\Models\Post::whereDate('created_at', today())->count() }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">System Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><strong>PHP Version:</strong> {{ PHP_VERSION }}</li>
                        <li class="mb-2"><strong>Laravel Version:</strong> {{ app()->version() }}</li>
                        <li class="mb-2"><strong>Database:</strong> {{ config('database.default') }}</li>
                        <li><strong>Environment:</strong> {{ app()->environment() }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .table th {
        border-top: none;
        font-weight: 600;
    }
</style>
@endpush