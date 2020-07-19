@extends('layouts.app')
@section('title', $post->title ?? 'Update post')

@push('styles')
    {{-- Push that script to head to momentarily create text editor on page --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
    <style>
        .alert-danger {
            margin-bottom: 5px;
        }
    </style>
@endpush

@section('content')

    <div class="container ck-content">
        @component('admin.components.breadcrumb')
            @slot('title') Update post @endslot
            @slot('parent') Main @endslot
            @slot('middle_pages', ['post.index' => 'Posts'])
            @slot('active') Update post @endslot
        @endcomponent
        <hr>
        <form class="form" method="post" action="{{ route('post.update', ['post' => $post]) }}">
            @method('put')
            @csrf
            @captcha
            <div class="form-group">
                @error('post_title')
                    <div class="alert-danger p-1">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Post title</span>
                    </div>
                    <input required type="text" class="form-control" name="post_title" maxlength="190" value="{{ old('post_title') ?? $post->title }}" placeholder="Some title for the post">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-primary">Update</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group d-inline">
                    @error('post_text')
                        <div class="alert-danger p-1">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                    <textarea name="post_text" id="editor">{{ old('post_text') ?? $post->text }}</textarea>
                </div>
            </div>
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
