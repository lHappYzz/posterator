@extends('layouts.app')
@section('title', 'Profile')
@push('styles')
    <style>
        table {
            width: 100%;
            margin: auto;
        }
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
                                <td class="title" colspan="2"><h4>{{ $user->name }}</h4></td>
                            </tr>
                            <tr>
                                <td colspan="2">Registered: {{ $user->created_at->format('M d Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Last update on: {{ $user->updated_at->format('M d Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <td>Email: {{ $user->email }}</td>
                                <td>Verified: {!! isset($user->email_verified_at) ? $user->email_verified_at->format('M d Y, H:i') : "<i class='fa fa-times-circle'></i>" !!}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Role: {{ $user->role->name }}</td>
                            </tr>
                        </table>

                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
