@extends('admin.layouts.app_admin')
@section('title', 'All posts')

@push('styles')
    <link href="{{ asset('css/adminTableStyles.css') . "?v=" . filemtime(public_path() . "/css/adminTableStyles.css") }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        @component('admin.components.breadcrumb')
            @slot('title') Posts list @endslot
            @slot('parent') Main @endslot
            @slot('active') Posts @endslot
        @endcomponent
        <hr>
        <a href="{{ route('post.create') }}" class="btn btn-block btn-outline-primary my-3"><i class="fa fa-plus"></i> Create post</a>
        <table class="table table-hover text-center">
            <thead>
            <tr>
                <th>Title</th>
                <th>Published</th>
                <th>Created by</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @forelse($posts as $post)
                <tr>
                    <td>{{ $post->title ?? 'none'}}</td>
                    <td>{{ $post->published ? 'Published':'Not published'}}</td>
                    <td>{{ $post->creator->name ?? 'none' }}</td>
                    <td>{{ $post->created_at ?? 'none'}}</td>
                    <td>{{ $post->updated_at ?? 'none' }}</td>
                    <td>
                        {{--<a class="btn btn-outline-primary" href="{{ route('post.show', ['post' => $post->slug]) }}"><i class="fa fa-eye"></i></a>--}}
                        <a class="btn btn-outline-primary" href="{{ action('PostController@show', ['post' => $post->slug]) }}"><i class="fa fa-eye"></i></a>
                        @include('admin.components.confirmModalWindow', [
                            'model' => $post,
                            'modalTitle'=>'Delete the post',
                            'message' => 'Are you sure you want to delete the post: "' . $post->title . '" with all data?',
                            'action' => route('post.destroy', ['post' => $post->slug])
                        ])
                        <a class="btn btn-outline-primary" href="{{ route('post.edit', ['post' => $post->slug]) }}"><i class="fa fa-edit"></i></a>
                        <button data-toggle="modal" data-target="#ModalCenter{{$post->id}}" type="button" value="delete" class="btn btn-outline-primary"><i class="fa fa-trash"></i></button>
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
                        {{$posts->links()}}
                    </ul>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection
