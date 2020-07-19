@extends('layouts.app')
@section('title', 'Profile')
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
                        @include('admin.components.postElement', ['post' => $lastPost])
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
