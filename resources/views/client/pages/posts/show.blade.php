@extends('layouts.app')
@section('title', $post->title ?? 'Post review')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/css/postShow.css')}}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
    </style>
@endpush
@section('content')
    <div class="container">

        @auth
            @if(Auth()->user()->hasRole('admin'))
                @component('admin.components.breadcrumb')
                    @slot('title') Post review @endslot
                    @slot('parent') Main @endslot
                    @slot('middle_pages', ['post.index' => 'Posts'])
                    @slot('active') Post review @endslot
                @endcomponent
                <hr>
            @endif
        @endauth

        <div class="blog-content">
            <div class="font-weight-bold">
                <h1>{{ $post->title ?? 'none' }}</h1>
                <div class="creator font-weight-light">
                    <p>Written by <span class="creator-name">{{ $post->creator->name }}</span> {{ $post->updated_at->format('M d Y, H:i') }}</p>
                </div>
            </div>
            <div class="text-body">
                {!! $post->text !!}
            </div>
            <div class="comments-block">
                <hr>
                <div class="d-inline-flex mb-2">
                    <h2 class="mb-0 mr-2">Comments</h2>
                    <button class="btn btn-outline-primary" onclick="removeReplierNameFromCommentForm()">New comment</button>
                </div>
                @auth
                    <div class="make-new-comment">
                        <form id="commentForm" class="form" data-comment-upload-url="{{route('comment.store')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$post->id}}" name="postId">
                            <input type="hidden" name="parent_comment_id">
                            <div class="form-group">
                                <div class="input-group">
                                    <textarea required maxlength="255" style="max-height: 150px; min-height: 50px" class="form-control" placeholder="Write a comment" name="comment_text" id="comment-text" cols="30" rows="10"></textarea>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary g-recaptcha" name="newComment" type="submit" data-sitekey="6LcrRrEZAAAAAOgcmU_fDA1B2LqDmmB5hHQFRcN-" data-callback='callback'>Create</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endauth
                <div class="comments-list" id="comment-list">
                    @includeWhen($comments->count() > 0, 'client.pages.posts.comments.comments', ['comments' => $comments])
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{asset('public/js/postShow.js') . "?v=" . filemtime(public_path() . "/js/postShow.js") }}"></script>
@endpush
