@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/css/postShow.css')}}">
@endpush
@section('content')
    <div class="container">
        <div class="posts">
            @forelse($posts as $post)
                <div class="post-{{$post->id}}">
                    <h1><a href="#">{{ $post->title ?? 'none' }}</a></h1>
                </div>
            @empty
                <div class="text-center" >
                    <h1>There is nothing yet</h1>
                </div>
            @endforelse
        </div>
    </div>
@endsection
