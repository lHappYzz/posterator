@extends('admin.layouts.app_admin')
@push('styles')
    <style>
        .creator-name{
            border-bottom: 2px solid red;
        }
        .font-weight-light > p {

            font-size: 13px;
        }
    </style>
    @endpush
@section('content')
    <div class="container">
        @component('admin.components.breadcrumb')
            @slot('title') Post review @endslot
            @slot('parent') Main @endslot
            @slot('middle_pages', ['admin.post.index' => 'Posts'])
            @slot('active') Post review @endslot
        @endcomponent
        <hr>
        <div class="blog-content">
            <div class="font-weight-bold">
                <h1>{{ $post->title }}</h1>
                <div class="font-weight-light">
                    <p>Written by <span class="creator-name">{{ $post->creator->name }}</span> {{ $post->updated_at->format('M d Y, H:i') }}</p>
                </div>
            </div>
            <div class="text-body">
                {!! $post->text !!}
            </div>
        </div>
    </div>
@endsection
