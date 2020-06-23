@extends('admin.layouts.app_admin')
@section('content')
    <div class="container">
            <div class="row text-center">
                <div class="col-sm-3">
                    <div class="jumbotron">
                        <h4>Total (all time): {{$totalPosts}}</h4>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="jumbotron">
                        <h4>Today you have: {{$todayPosts}}</h4>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="jumbotron">
                        <h4>Compared with same day on last week, you have: {{$compareWithLastWeekDay}}</h4>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="jumbotron">
                        <h4>On this week you have: {{$weekPosts}}</h4>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="jumbotron">
                        <h4>Compared with last week, you have: {{$compareWithLastWeek}}</h4>
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
