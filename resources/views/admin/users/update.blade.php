@extends('admin.layouts.app_admin')
@push('styles')
    @endpush
@section('content')
    <div class="container ck-content">
        @component('admin.components.breadcrumb')
            @slot('title') Update user @endslot
            @slot('parent') Main @endslot
            @slot('middle_pages', ['admin.user.index' => 'Users'])
            @slot('active') Update user @endslot
        @endcomponent
        <hr>
        <form class="form" method="post" action="{{ route('admin.user.update', ['user' => $user]) }}">
            @method('put')
            @csrf
            <div class="form-group">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">User name</span>
                        </div>
                        <input type="text" class="form-control" name="user_name" maxlength="30" value="{{$user->name}}" placeholder="Some name for the user">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" type="submit">Update</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">User email</span>
                            </div>
                            <input type="text" class="form-control" name="user_email" maxlength="30" value="{{$user->email}}" placeholder="Some email">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Created at</span>
                            </div>
                            <input readonly type="text" class="form-control" name="user_createdAt" maxlength="30" value="{{$user->created_at}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Role</span>
                        </div>
                        <select class="custom-select" name="role_name">
                            <option selected value="{{$user->role->name}}">{{$user->role->name}}</option>
                            @foreach($roles as $role)
                                @if($role->name !== $user->role->name)
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">New password</span>
                            </div>
                            <input placeholder="Some password" type="password" class="form-control" name="user_password" maxlength="30" value="">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
