@extends('layouts.app')
@push('styles')
    <style>
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="user-materials col-sm-6">
                <a href="{{ route('user.page.profile.posts') }}"><h4>Materials ({{$user->posts->count()}})</h4></a>
                <hr>
                <div class="user-last-material">
                    @if($lastPost)
                        <a href="{{route('post.show', ['post' => $lastPost->slug])}}" class="list-group-item bg-light list-group-item-action">
                            <h4 class="list-group-item-heading">{{$lastPost->title}}</h4>
                            <div class="postInfo font-weight-light">
                                <p><span class="createdAt"><i class="fa fa-calendar"></i> {{ $lastPost->created_at->format('M d Y, H:i') }}</span>
                                    <i class="fa fa-user-circle"></i> <span class="createdBy">{{ $lastPost->creator->name }}</span>
                                    <span class="commentsCount"><i class="fa fa-comments"></i> {{ $lastPost->comments->count() }}</span></p>
                            </div>
                            <div class="shortDesc">
                                {{$lastPost->shortDesc(130)}}
                            </div>
                        </a>
                    @endif
                </div>
            </div>
            <div class="user-data col-sm-6">
                <a href="{{ route('user.page.profile.edit') }}"><h4>Profile edit</h4></a>
                <hr>
                <div class="user-data">
                    <a href="{{ route('user.page.profile.edit') }}" class="list-group-item bg-light list-group-item-action">
                        <table>
                            <tr>
                                <td><h4>{{ $user->name }}</h4></td>
                            </tr>
                            <tr>
                                <td>Registered: {{ $user->created_at->format('M d Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <td>Last update on: {{ $user->updated_at->format('M d Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <td>Email: {{ $user->email }}</td>
                                <td>Verified: {!! $user->verified_at ? $user->verified_at->format('M d Y, H:i') : "<i class='fa fa-times-circle'></i>" !!}</td>
                            </tr>
                            <tr>
                                <td>Role: {{ $user->role->name }}</td>
                            </tr>
                        </table>

                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
