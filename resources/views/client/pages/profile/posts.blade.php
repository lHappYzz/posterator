@extends('layouts.app')
@push('styles')
    <style>
        .progress{
            border-radius: 0;
            height: 4px;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <a href="{{ route('user.page.profile') }}" class="btn btn-block btn-outline-primary">Profile</a>
        <a href="{{ route('post.create') }}" class="btn btn-block btn-outline-primary">Create material</a>
        <div class="post-list">
            @forelse($posts as $post)
                <div class="post" data-id="{{$post->id}}">
                    <a href="{{route('post.show', ['post' => $post->slug])}}" class="list-group-item bg-light list-group-item-action">
                        <h4 class="list-group-item-heading">{{$post->title}}</h4>
                        <div class="shortDesc">
                            {{$post->shortDesc(130)}}
                        </div>
                    </a>
                    @if($post->published)
                        <div class="progress">
                            <div class="bg-success" style="width: 100%;"></div>
                        </div>
                    @else
                        <div class="progress">
                            <div class="bg-danger" style="width: 100%;"></div>
                        </div>
                    @endif
                </div>
            @empty
                <h3>Missing data</h3>
            @endforelse
        </div>

        <div class="pagination">
            <ul class="pagination">
                {{$posts->links()}}
            </ul>
        </div>
    </div>
@endsection
