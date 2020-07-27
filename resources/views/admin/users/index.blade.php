@extends('admin.layouts.app_admin')
@push('styles')
    <link href="{{asset('public/css/adminTableStyles.css') . "?v=" . filemtime(public_path() . "/css/adminTableStyles.css") }}" rel="stylesheet">
@endpush
@section('content')
    <div class="container">
        @component('admin.components.breadcrumb')
            @slot('title') Users list @endslot
            @slot('parent') Main @endslot
            @slot('active') Users @endslot
        @endcomponent
        <hr>
        <a href="{{ route('admin.user.create') }}" class="btn btn-block btn-outline-primary my-3"><i class="fa fa-plus"></i> Create user</a>
        <table class="table table-hover text-center">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Verified at</th>
                <th>Created at</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name ?? 'none'}}</td>
                    <td>{{ $user->email ?? 'none'}}</td>
                    <td>{{ $user->role->name ?? 'none'}}</td>
                    <td>{{ $user->email_verified_at ?? 'none'}}</td>
                    <td>{{ $user->created_at ?? 'none'}}</td>
                    <td>
{{--                        <a class="btn btn-outline-primary" href="{{ route('admin.user.show', ['user' => $user->id]) }}"><i class="fa fa-eye"></i></a>--}}
                        @include('admin.components.confirmModalWindow', [
                            'model' => $user,
                            'modalTitle'=>'Delete the user',
                            'message' => 'Are you sure you want to delete the user: "' . $user->name . '"?',
                            'action' => route('admin.user.destroy', ['user' => $user->id])
                        ])
                        <a class="btn btn-outline-primary" href="{{ route('admin.user.edit', ['user' => $user->id]) }}"><i class="fa fa-edit"></i></a>
                        <button data-toggle="modal" data-target="#ModalCenter{{$user->id}}" type="button" value="delete" class="btn btn-outline-primary"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center"><h3>Missing data</h3></td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <td colspan="6">
                    <ul class="pagination">
                        {{$users->links()}}
                    </ul>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection
