@extends('layouts.app')
@section('title', 'My posts')
@push('styles')
    <style>
        button.list-group-item{
            min-width: 125px;
            border-radius: 0;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <a href="{{ route('user.page.profile') }}" class="btn btn-block btn-outline-primary">Profile</a>
        <a href="{{ route('post.create') }}" class="btn btn-block btn-outline-primary">Create material</a>
        <div class="post-list">
            @forelse($posts as $post)
                <div class="post" data-id="{{$post->id}}">
                    <div class="list-group list-group-horizontal-lg">

                        {{-- render comment block --}}
                        @include('admin.components.postElement', ['post' => $post])

                        <form id="post-edit-{{$post->id}}" action="{{ route('post.edit', ['post' => $post]) }}"></form>

                        @include('admin.components.confirmModalWindow', [
                                'model' => $post,
                                'modalTitle'=>'Delete the post',
                                'message' => 'Are you sure you want to delete the post: "' . $post->title . '" with all data?',
                                'action' => route('post.destroy', ['post' => $post])
                            ])
                        <button data-toggle="modal" data-target="#ModalCenter{{$post->id}}" type="button" value="delete" class="list-group-item btn btn-outline-danger"><i class="fa fa-trash"></i></button>

                        <button class="list-group-item btn btn-outline-primary"
                                onclick="event.preventDefault();
                                    document.getElementById('post-edit-{{$post->id}}').submit();">
                            Edit
                        </button>
                        @if($post->published)
                            <button id="publicationButton" aria-hidden="true" data-status="true" data-id="{{$post->id}}" type="button" class="list-group-item btn btn-outline-success">Published</button>
                        @else
                            <button id="publicationButton" aria-hidden="true" data-status="false" data-id="{{$post->id}}" type="button" class="list-group-item btn btn-outline-danger">Not published</button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center pt-3">
                    <h3>Missing data</h3>
                </div>
            @endforelse
            <div class="pagination">
                <ul class="pagination">
                    {{$posts->links()}}
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('button#publicationButton').on('click', function () {
                let status = this.getAttribute("data-status");

                if (status === 'true') {
                    status = 0;
                } else {
                    status = 1;
                }
                console.log(status);

                let postId = this.getAttribute("data-id");
                let element = this;

                element.disabled = true;
                element.innerHTML = `
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...`;
                $.ajax({
                    method: "POST",
                    url: "{{ route('post.publish') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": postId,
                        "status": status
                    }
                }).done(function( result ) {
                    if(result){
                        element.disabled = false;
                        result = JSON.parse(result);
                        element.setAttribute('data-status', result.status);
                        if(result.status === true){
                            element.className = 'list-group-item btn btn-outline-success';
                            element.innerHTML = 'Published';
                        } else if(result.status === false) {
                            element.className = 'list-group-item btn btn-outline-danger';
                            element.innerHTML = 'Not published';
                        }
                    }
                })
                .fail(function() {
                    if(status === true){
                        element.className = 'list-group-item btn btn-outline-success';
                        element.innerHTML = 'Published';
                    } else {
                        element.className = 'list-group-item btn btn-outline-danger';
                        element.innerHTML = 'Not published';
                    }
                    element.disabled = false;
                })
            })
        })
    </script>
@endpush
