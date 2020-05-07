@extends('admin.layouts.app_admin')
@push('styles')
@endpush
@section('content')
    <div class="container ck-content">
        @component('admin.components.breadcrumb')
            @slot('title') Create user @endslot
            @slot('parent') Main @endslot
            @slot('middle_pages', ['admin.user.index' => 'Users'])
            @slot('active') Create user @endslot
        @endcomponent
        <hr>
        <form class="form" method="post" action="{{ route('admin.user.store') }}">
            @csrf
            <div class="form-group">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">User name</span>
                        </div>
                        <input type="text" class="form-control  @error('user_name') is-invalid @enderror" name="user_name" maxlength="30" value="{{ old('user_name') }}" placeholder="Some name for the user">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" type="submit">Create</button>
                        </div>
                        @error('user_name')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">User email</span>
                            </div>
                            <input type="text" class="form-control  @error('user_email') is-invalid @enderror" name="user_email" maxlength="30" value="{{ old('user_email') }}" placeholder="Some email">
                            @error('user_email')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Role</span>
                        </div>
                        <select class="custom-select" name="role_name">
                            @foreach($roles as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
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
                            <input placeholder="Some password" type="password" class="form-control  @error('user_password') is-invalid @enderror" name="user_password" maxlength="30" value="">
                            @error('user_password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
