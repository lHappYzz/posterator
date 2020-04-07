@extends('admin.layouts.app_admin')
@section('content')

    <div class="container ck-content">
        @component('admin.components.breadcrumb')
            @slot('title') Update post @endslot
            @slot('parent') Main @endslot
            @slot('middle_pages', ['admin.post.index' => 'Posts'])
            @slot('active') Update post @endslot
        @endcomponent
        <hr>
        <form class="form" method="post" action="{{ route('admin.post.update', ['post' => $post]) }}">
            @method('put')
            @csrf
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Post title</span>
                    </div>
                    <input type="text" class="form-control" name="post_title" maxlength="30" value="{{ $post->title }}" placeholder="Some title for the post">
                </div>
                <div class="input-group d-inline">
                    <textarea name="post_text" id="editor">{{ $post->text }}</textarea>
                </div>
                <button type="submit" class="btn btn-outline-primary">Update</button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="/public/js/scripts.js?v=26"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ), {

            })
            .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endpush
