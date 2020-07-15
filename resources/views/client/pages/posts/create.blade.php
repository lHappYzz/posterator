@extends('layouts.app')
@section('title', 'Create new post')

@push('styles')
    {{-- Push that script to head to momentarily create text editor on page --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
@endpush

@section('content')
    <div class="container">
        @if(Auth::user()->hasRole('admin'))
            @component('admin.components.breadcrumb')
                @slot('title') Create post @endslot
                @slot('parent') Main @endslot
                @slot('middle_pages', ['post.index' => 'Posts'])
                @slot('active') Create post @endslot
            @endcomponent
            <hr>
        @else
            <h2>Create post</h2>
        @endif
        <form class="form" method="post" action="{{ route('post.store') }}">
            @csrf
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Post title</span>
                    </div>
                    <input required type="text" class="form-control" name="post_title" maxlength="200" value="{{ old('post_title') }}" placeholder="Some title for the post">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-primary">Create</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group d-inline">
                    <textarea name="post_text" id="editor">{{ old('post_text') }}</textarea>
                </div>
            </div>
            @captcha
        </form>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                ckfinder: {
                    options: {
                        resourceType: 'Images'
                    },
                    uploadUrl: '{{route('image.upload', ['_token' => csrf_token() ])}}'
                }
            })
            .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endpush
