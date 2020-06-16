@extends('layouts.app')
@push('styles')
    <style>

    </style>
@endpush
@section('content')
    <div class="container ck-content">
        <h2>Profile edit</h2>
        <a href="{{ route('user.page.profile') }}" class="btn btn-block btn-outline-primary">Profile</a>
        <hr>
        <form class="form" method="post" action="{{ route('user.page.profile.update', ['user' => $user->id]) }}">
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
                            <button class="btn btn-outline-primary" type="submit">Save</button>
                        </div>
                        @error('user_name')
                        <span class="invalid-feedback" style="display: block">
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
                            <input disabled type="text" class="form-control" name="user_email" maxlength="30" value="{{$user->email}}" placeholder="Some email">
                            @error('user_email')
                            <span class="invalid-feedback" style="display: block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Registered at</span>
                            </div>
                            <input disabled type="text" class="form-control" name="user_createdAt" maxlength="30" value="{{$user->created_at}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Role</span>
                        </div>
                        <input class="form-control" type="text" disabled name="role-name" value="{{$userRole->name}}">
                    </div>
                </div>
                <hr>
                <div class="passwordChange">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">New password</span>
                                    <div class="input-group-text">
                                        <input onchange="disabledAttrChange()" id="passwordCheckBox" type="checkbox">
                                    </div>
                                </div>
                                <input disabled placeholder="Some password" type="password" class="form-control" id="newUserPassword" name="new_user_password" maxlength="30" value="">
                                @error('new_user_password')
                                    <span class="invalid-feedback" style="display: block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Confirm password</span>
                                </div>
                                <input disabled placeholder="Confirm password" type="password" class="form-control" id="newUserPasswordConfirmation" name="new_user_password_confirmation" maxlength="30" value="">
                                @error('user_password_confirmation')
                                <span class="invalid-feedback" style="display: block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Old password</span>
                                </div>
                                <input disabled placeholder="Old password" type="password" class="form-control" id="oldUserPassword" name="old_user_password" maxlength="30" value="">
                                @error('old_user_password')
                                <span class="invalid-feedback" style="display: block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        function disabledAttrChange() {
            let checkBoxStatus = passwordCheckBox.checked;
            newUserPassword.disabled = !checkBoxStatus;
            oldUserPassword.disabled = !checkBoxStatus;
            newUserPasswordConfirmation.disabled = !checkBoxStatus;
        }
    </script>
@endpush
