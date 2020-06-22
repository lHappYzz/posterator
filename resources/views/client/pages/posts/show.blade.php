@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/css/postShow.css')}}">
    <style>
    </style>
@endpush
@section('content')
    <div class="container">

        @auth
            @if(Auth()->user()->hasRole('admin'))
                @component('admin.components.breadcrumb')
                    @slot('title') Post review @endslot
                    @slot('parent') Main @endslot
                    @slot('middle_pages', ['post.index' => 'Posts'])
                    @slot('active') Post review @endslot
                @endcomponent
                <hr>
            @endif
        @endauth


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
                @auth
                    <div class="make-new-comment">
                        <form id="commentForm" class="form" action="{{route('comment.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <div class="input-group">
                                    <textarea required maxlength="255" style="max-height: 150px; min-height: 50px" class="form-control" placeholder="Write a comment" name="comment_text" id="comment-text" cols="30" rows="10"></textarea>
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
                @endauth
                <div class="comments-list" id="comment-list">
                    @includeWhen($comments->count() > 0, 'client.pages.posts.comments.comments', ['comments' => $comments])
                </div>
            </div>
        </div>
    </div>
@endsection
{{--TODO: Вынести этот мусор в отдельный файл--}}
@push('scripts')
    <script type="text/javascript">
        function showAnswers(spanElement, commentId) {
            let commentReplies = document.getElementById('replies-'+commentId);
            if(commentReplies){
                if (commentReplies.style.display === 'none'){
                    spanElement.innerText = "Close answers";
                    commentReplies.style.display = 'block';
                } else {
                    spanElement.innerText = 'Show answers';
                    commentReplies.style.display = 'none';
                }
            } else {
                console.log('Can not find element');
            }
        }
        function animationFindParentComment(linkElement, e) {
            e.preventDefault();
            let parentCommentId = linkElement.getAttribute('href');

            $(parentCommentId).removeClass('animate');

            setTimeout(function(){
                $(parentCommentId).addClass("animate");
            },10); //wait some ms to restart anim

            $('html, body').animate({scrollTop: $(parentCommentId).offset().top}, 200, function () {
                setTimeout(function(){
                    $(parentCommentId).removeClass("animate");
                },1000);
            });
            return false;
        }
        function showCommentForm(commentId){
            let forms = document.forms;
            Array.prototype.forEach.call(forms, function(form) {
                if(form.id === 'answerCommentForm'){
                    form.remove();
                }
            });
            let form = `
                <form id="answerCommentForm" class="form" action="{{route('comment.store')}}" method="post" >
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <textarea required maxlength="255" style="max-height: 150px; min-height: 50px" class="form-control" placeholder="Write a comment" name="comment_text" id="comment-text" cols="30" rows="10"></textarea>
                            <div class="input-group-append">
                                <button name="newComment" class="btn btn-outline-primary" type="submit">Create</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" value="{{$post->id}}" name="postId" hidden>
                        <input type="text" value="${commentId}" name="parent_comment_id" hidden>
                    </div>
                </form>
            `;
            let repliesToComment = document.getElementById("replies-"+ commentId);
            if (!repliesToComment) {
                let comment = document.getElementById("comment-"+ commentId);
                comment.insertAdjacentHTML('beforeEnd', form);
                return;
            }
            repliesToComment.insertAdjacentHTML('beforebegin', form);
        }

        function findRepliesList(childCommentId) {
            let childComment = document.getElementById('comment-'+childCommentId);
            let repliesList = childComment.parentElement;

            if (repliesList.className === 'replies-list'){
                return repliesList;
            }
            repliesList = document.getElementById('replies-list-'+childCommentId);
            return repliesList;
        }
        function checkRepliesListDisplayAttr(commentId) {
            let comment = document.getElementById('comment-'+commentId);
            let basicCommentId = comment.getAttribute('data-basic-comment-id');

            if (!basicCommentId){
                let commentSibling = comment.previousElementSibling;
                while (!basicCommentId) {
                    if (!commentSibling) {
                        basicCommentId = comment.getAttribute('data-parent-id');
                        let basicRepliesList = document.getElementById('replies-'+basicCommentId);
                        let basicCommentAction = document.getElementById('comment-action-'+basicCommentId);
                        let showMoreAnswerButton = `
                            <span class="text-secondary" onclick="showAnswers(this, ${basicCommentId})" id="showMoreAnswer-${basicCommentId}">Close answers</span>
                        `;
                        basicCommentAction.insertAdjacentHTML('beforeEnd', showMoreAnswerButton);
                        basicRepliesList.style.display = 'block';
                        return;
                    }
                    commentSibling = commentSibling.previousElementSibling;
                    if(!commentSibling){
                        return false;
                    }
                    basicCommentId = commentSibling.getAttribute('data-parent-id');
                }
            }
            let basicCommentRepliesList = document.getElementById('replies-'+basicCommentId);

            if (!basicCommentRepliesList) return false;

            basicCommentRepliesList.style.display = 'block';
            let showMoreAnswerButton = document.getElementById('showMoreAnswer-'+basicCommentId);
            showMoreAnswerButton.innerHTML = 'Close answers';
        }
        function pasteComment(result) {
            let createdAt = result.created_at;
            if(result.parent_comment_id) {
                let parentCommentCreator = document.getElementById('comment-'+result.parent_comment_id).getAttribute('data-creator');
                let commentHtml = `
                    <li class="reply-comment-item" id="comment-${result.id}" data-creator="${result.creator}" data-parent-id="${result.parent_comment_id}">
                        <div class="comment-creator">
                            <b>${result.creator}</b>, ${createdAt}
                        </div>
                        <div class="comment-text">
                            <a href="#comment-${result.parent_comment_id}" onclick="animationFindParentComment(this, event)" class="answerTo badge badge-info">
                                @${parentCommentCreator}
                            </a>
                            ${result.comment}
                        </div>
                        <div class="comment-action">
                            <span onclick="showCommentForm(${result.id})" id="answer" class="answer text-info">Reply</span>
                        </div>
                    </li>
                `;
                let repliesList = findRepliesList(result.parent_comment_id);
                repliesList.insertAdjacentHTML('beforeEnd', commentHtml);
                checkRepliesListDisplayAttr(result.id);
                return;
            }
            let commentList = document.getElementById('comment-list');

            let commentHtml = `
                <div class="comment-block">
                    <div class="comment-item" id="comment-${result.id}" data-creator="${result.creator}">
                        <div class="comment-creator">
                            <b>${result.creator}</b>, ${createdAt}
                        </div>
                        <div class="comment-text">
                            ${result.comment}
                        </div>
                        <div class="comment-action" id="comment-action-${result.id}">
                            <span onclick="showCommentForm(${result.id})" id="answer" class="answer text-info">Reply</span>
                        </div>
                    </div>
                    <div class="replies" id="replies-${result.id}" data-basic-comment-id="${result.id}" style="display: none">
                        <ol class="replies-list" id="replies-list-${result.id}"></ol>
                    </div>
                </div>
            `;
            commentList.insertAdjacentHTML('beforeEnd', commentHtml);
        }
        document.onsubmit = function (e) {
            e.preventDefault();

            let buttonFormElement = e.target.elements.namedItem('newComment');

            buttonFormElement.disabled = true;
            buttonFormElement.innerHTML = `
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
            `;

            let formData = new FormData;
            if (e.target.id === 'commentForm'){
                formData = new FormData(commentForm);
                commentForm.elements.namedItem('comment_text').value = '';
            } else if(e.target.id === 'answerCommentForm'){
                formData = new FormData(answerCommentForm);
                answerCommentForm.elements.namedItem('comment_text').value = '';
            } else {
                return;
            }
            let xhr = new XMLHttpRequest();
            xhr.open('post', '{{route('comment.store')}}');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200){

                    buttonFormElement.disabled = false;
                    buttonFormElement.innerHTML = 'Create';

                    if (typeof answerCommentForm !== 'undefined') {
                        answerCommentForm.remove();
                    }

                    let result = JSON.parse(xhr.responseText);
                    if (result){
                        if (result.error) {
                            console.log(result.error);
                            return false;
                        }
                        pasteComment(result);
                    }
                }
                buttonFormElement.disabled = false;
                buttonFormElement.innerHTML = 'Create';
            };
            xhr.send(formData);
        };
    </script>
@endpush
