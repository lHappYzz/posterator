@extends('admin.layouts.app_admin')
@section('title', 'Admin dashboard')
@push('styles')
    <style>
        .post-title {
            word-break: break-word;
        }
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

                            {{-- render comment block --}}
                            @include('admin.components.postElement', ['post' => $post])

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
