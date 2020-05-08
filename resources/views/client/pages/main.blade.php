@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/css/postShow.css')}}">
@endpush
@section('content')
    <div class="container">
        <div class="posts">
            @forelse($posts as $post)
                @if($post->published)
                    <div class="post-{{$post->id}}">
{{--                        <h1><a href="{{ url('post/'.$post->slug) }}">{{ $post->title ?? 'none' }}</a></h1>--}}
                        <h1><a href="{{ action('PostController@show', ['post' => $post->slug]) }}">{{ $post->title ?? 'none' }}</a></h1>
                    </div>
                @endif
            @empty
                <div class="text-center" >
                    <h1>There is nothing yet</h1>
                </div>
            @endforelse
        </div>
    </div>
@endsection
