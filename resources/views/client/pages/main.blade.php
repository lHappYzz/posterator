@extends('layouts.app')
@section('title', 'Posts')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/css/postShow.css')}}">
    <style>
        .shortDesc {
            word-break: break-all;
        }
        div.title > a {
            color: black;
            font-size: 35px;
        }
        .post {
            padding-bottom: 10px;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="posts">
            @forelse($posts as $post)
                <div class="post" data-id="{{$post->id}}">
                    <div class="title">
                        <a class="post-title" href="{{ action('PostController@show', ['post' => $post->slug]) }}">{{ $post->title ?? 'none' }}</a>
                    </div>
                    <div class="postInfo font-weight-light">
                        <p><span class="createdAt"><i class="fa fa-calendar"></i> {{ $post->created_at->format('M d Y, H:i') }}</span>
                        <i class="fa fa-user-circle"></i> <span class="createdBy">{{ $post->creator->name }}</span>
                        <span class="commentsCount"><i class="fa fa-comments"></i> {{ $post->comments->count() }}</span></p>
                    </div>
                    <div class="shortDesc">
                        {{ $post->shortDesc() }}
                    </div>
                </div>
            @empty
                <div class="text-center" >
                    <h1>There is nothing yet</h1>
                </div>
            @endforelse
            <ul class="pagination">
                {{$posts->links()}}
            </ul>
        </div>
    </div>
@endsection
