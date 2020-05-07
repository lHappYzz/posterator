@extends('admin.layouts.app_admin')
@section('content')
    <div class="container">
            <div class="row text-center">
                <div class="col-sm-3">
                    <div class="jumbotron">
                        <h4>Categories: {{$categories->count()}}</h4>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="jumbotron">
                        <h4>Materials: {{$posts->count()}}</h4>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="jumbotron">
                        <h4>Users: {{$users->count()}}</h4>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="jumbotron">
                        <h4>Today: 0</h4>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-sm-6">
                <a href="{{ route('admin.category.create') }}" class="btn btn-block btn-outline-primary">Create category</a>
                <a href="#" class="list-group-item list-group-item-action">
                    <h4 class="list-group-item-heading">First category</h4>
                    <p class="llist-group-item-text">Count</p>
                </a>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('post.create') }}" class="btn btn-block btn-outline-primary">Create material</a>
                <a href="#" class="list-group-item list-group-item-action">
                    <h4 class="list-group-item-heading">First material</h4>
                    <p class="llist-group-item-text">Category</p>
                </a>
            </div>
        </div>
    </div>
@endsection
