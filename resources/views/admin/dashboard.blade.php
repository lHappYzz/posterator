@extends('admin.layouts.app_admin')
@push('styles')
    <style>
        button.list-group-item{
            border-radius: 0;
        }
        .btn:focus, .btn:active {
             box-shadow: none !important;
         }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="statistics jumbotron border border-info">
            <table class="table table-hover">
                <thead class="text-center">
                    <tr>
                        <th colspan="2">Statistics</th>
                    </tr>
                </thead>
                <tr>
                    <td>Total:</td>
                    <td>{{$posts->count()}}</td>
                </tr>
                <tr>
                    <td>Today:</td>
                    <td>{{$todayPosts->count()}}</td>
                </tr>
                <tr>
                    <td>Compared with same day on last week:</td>
                    <td class="{{ $compareWithLastWeekDay['className'] }}">{{$compareWithLastWeekDay['percentDiff']}}</td>
                </tr>
                <tr>
                    <td>On this week:</td>
                    <td>{{$weekPosts->count()}}</td>
                </tr>
                <tr>
                    <td>Compared with last week:</td>
                    <td class="{{ $compareWithLastWeek['className'] }}">{{$compareWithLastWeek['percentDiff']}}</td>
                </tr>
            </table>
        </div>
        <div class="row">
            <div class="col">
                <div class="card-header text-center ">
                    <h4 class="mb-0">Last posts</h4>
                </div>
                <a href="{{ route('post.create') }}" class="btn btn-block btn-outline-primary">Create material</a>
                @forelse($lastThreePosts as $post)
                    <div class="post" data-id="{{$post->id}}">
                        <div class="list-group list-group-horizontal-sm">
                            <a href="{{route('post.show', ['post' => $post->slug])}}" class="list-group-item bg-light list-group-item-action">
                                <h4 class="mb-1">{{$post->title}}</h4>
                                <div class="postInfo font-weight-light">
                                    <p><span class="createdAt"><i class="fa fa-calendar"></i> {{ $post->created_at->format('M d Y, H:i') }}</span>
                                        <span class="commentsCount"><i class="fa fa-comments"></i> {{ $post->comments->count() }}</span></p>
                                </div>
                                <p class="mb-1">{{$post->shortDesc(130)}}</p>
                            </a>
                            <form id="post-edit-{{$post->id}}" action="{{ route('post.edit', ['post' => $post]) }}"></form>

                            @include('admin.components.confirmModalWindow', [
                                'model' => $post,
                                'modalTitle'=>'Delete the post',
                                'message' => 'Are you sure you want to delete the post: "' . $post->title . '" with all data?',
                                'action' => route('post.destroy', ['post' => $post])
                            ])
                            <button data-toggle="modal" data-target="#ModalCenter{{$post->id}}" type="button" value="delete" class="list-group-item btn btn-outline-danger"><i class="fa fa-trash"></i></button>

                            <button class="list-group-item btn btn-outline-primary"
                                    onclick="event.preventDefault();
                                    document.getElementById('post-edit-{{$post->id}}').submit();">
                                Edit
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center pt-3">
                        <h1>There is nothing yet</h1>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
