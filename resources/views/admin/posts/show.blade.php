@extends('admin.layouts.app_admin')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/css/postShow.css')}}">
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
                <h1>{{ $post->title ?? 'none' }}</h1>
                <div class="creator font-weight-light">
                    <p>Written by <span class="creator-name">{{ $post->creator->name }}</span> {{ $post->updated_at->format('M d Y, H:i') }}</p>
                </div>
            </div>
            <div class="text-body">
                {!! $post->text !!}
            </div>
            <div class="comments-block">
                <hr>
                <h2>Comments</h2>
                <div class="make-new-comment">
                    <form id="commentForm" class="form" action="{{route('admin.comment.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <textarea maxlength="255" style="max-height: 150px; min-height: 50px" class="form-control" placeholder="Write a comment" name="comment_text" id="comment-text" cols="30" rows="10"></textarea>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" name="newComment" type="submit">Create</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" value="{{$post->id}}" name="postId" hidden>
                        </div>
                    </form>
                </div>
                <div class="comments-list">
                    <ol class="comment-list" id="commentBlock">
                        @includeWhen($comments->count() > 0, 'admin.posts.comments.comments', ['comments' => $comments])
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--TODO: Вынести этот мусор в отдельный файл. На момент последнего тестирования все работало--}}
@push('scripts')
    <script type="text/javascript">
        function showAnswers(spanElement, commentId) {
            let commentAnswers = document.getElementById('commentAnswers'+commentId);
            if (commentAnswers.style.display === 'none'){
                spanElement.innerText = "Close answers";
                commentAnswers.style.display = 'block';
            } else {
                spanElement.innerText = 'Show answers';
                commentAnswers.style.display = 'none';
            }
        }
        function showCommentForm(commentId){
            let forms = document.forms;
            Array.prototype.forEach.call(forms, function(form) {
                if(form.id === 'answerCommentForm'){
                    form.remove();
                }
            });
            let form = `
                <form id="answerCommentForm" class="form" action="{{route('admin.comment.store')}}" method="post" >
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <textarea maxlength="255" style="max-height: 150px; min-height: 50px" class="form-control" placeholder="Write a comment" name="comment_text" id="comment-text" cols="30" rows="10"></textarea>
                            <div class="input-group-append">
                                <button name="newAnswerComment" class="btn btn-outline-primary" type="submit">Create</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" value="{{$post->id}}" name="postId" hidden>
                        <input type="text" value="${commentId}" name="parent_comment_id" hidden>
                    </div>
                </form>
            `;
            let comment = document.getElementById("commentAnswers"+ commentId);
            comment.insertAdjacentHTML('beforebegin', form);
        }
        function pasteComment(result){
            let created_at = result.created_at;
            let comment = `
                <li class="comment-tree-item">
                    <div class="comment-item">
                        <div class="comment-creator">
                            <b>${result.creator}</b>, ${created_at}
                        </div>
                        <div class="comment-text">
                            ${result.comment}
                        </div>
                        <div class="comment-action">
                            <span onclick="showCommentForm(${result.id})" id="answer" class="answer text-info">Reply</span>
                            <span class="text-secondary" onclick="showAnswers(this, ${result.id})" id="showMoreAnswer">Close answers</span>
                        </div>
                        <div class="comment-answers" id="commentAnswers${result.id}" style="display: block">
                            <ol class="subcomment-list" id="subcomment-list-${result.id}"></ol>
                        </div>
                    </div>
                </li>
            `;
            if(result.parent_comment_id){
                let commentAnswersBlock = document.getElementById('commentAnswers'+result.parent_comment_id);
                let subcommentsList = document.getElementById('subcomment-list-'+result.parent_comment_id);
                subcommentsList.insertAdjacentHTML('beforeEnd', comment);
                commentAnswersBlock.style.display = 'block';
                answerCommentForm.remove();
            } else {
                let commentBlock = document.getElementById('commentBlock');
                commentBlock.insertAdjacentHTML('beforeEnd', comment);
            }
        }
        document.onsubmit = function (e) {
            e.preventDefault();
            let formData = new FormData;
            if (e.target.id === 'commentForm'){
                formData = new FormData(commentForm);
                commentForm.elements.namedItem('comment_text').value = '';
            } else if(e.target.id === 'answerCommentForm'){
                formData = new FormData(answerCommentForm);
            } else {
                return;
            }
            let xhr = new XMLHttpRequest();
            xhr.open('post', '{{route('admin.comment.store')}}');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200){
                    let result = JSON.parse(xhr.responseText);
                    if (result){
                        pasteComment(result);
                    }
                }
            };
            xhr.send(formData);
        }

    </script>
@endpush
