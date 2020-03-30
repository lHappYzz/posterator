@extends('admin.layouts.app_admin')
@section('content')
    <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="jumbotron">
                        <p>Categories 0</p>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="jumbotron">
                        <p>Materials 0</p>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="jumbotron">
                        <p>Users 0</p>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="jumbotron">
                        <p>Today 0</p>
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
                <a href="#" class="btn btn-block btn-outline-primary">Create material</a>
                <a href="#" class="list-group-item list-group-item-action">
                    <h4 class="list-group-item-heading">First material</h4>
                    <p class="llist-group-item-text">Category</p>
                </a>
            </div>
        </div>
    </div>
@endsection
