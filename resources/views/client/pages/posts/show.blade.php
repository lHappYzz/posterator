@extends('layouts.app')
@section('title', $post->title ?? 'Post review')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/css/postShow.css')}}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
                <div class="d-inline-flex mb-2">
                    <h2 class="mb-0 mr-2">Comments</h2>
                    <button class="btn btn-outline-primary" onclick="removeReplierNameFromCommentForm()">New comment</button>
                </div>
                @auth
                    <div class="make-new-comment">
                        <form id="commentForm" class="form" action="{{route('comment.store')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$post->id}}" name="postId">
                            <input type="hidden" name="parent_comment_id">
                            <div class="form-group">
                                <div class="input-group">
                                    <textarea required maxlength="255" style="max-height: 150px; min-height: 50px" class="form-control" placeholder="Write a comment" name="comment_text" id="comment-text" cols="30" rows="10"></textarea>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary g-recaptcha" name="newComment" type="submit" data-sitekey="6LcrRrEZAAAAAOgcmU_fDA1B2LqDmmB5hHQFRcN-" data-callback='callback'>Create</button>
                                    </div>
                                </div>
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
        function showAnswers(ShowAnswersButton, commentId) {
            let commentReplies = document.getElementById('replies-'+commentId);
            if(commentReplies){
                if (commentReplies.style.display === 'none'){
                    ShowAnswersButton.innerText = "Close answers";
                    commentReplies.style.display = 'block';
                } else {
                    ShowAnswersButton.innerText = 'Show answers';
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
                $(parentCommentId).on('webkitAnimationEnd', function () {
                    $(this).removeClass('animate');
                });
            },10); //wait some ms to restart anim


            $('html, body').animate({scrollTop: $(parentCommentId).offset().top}, 200);
            return false;
        }

        function removeReplierNameFromCommentForm() {
            let commentForm = document.getElementById('commentForm');
            if (!commentForm) return false;

            let replierNameOnForm = commentForm.querySelector('#replier-name');
            if (!replierNameOnForm) return false;

            //clear parent comment id input
            commentForm.querySelector('[name="parent_comment_id"]').value = '';
            replierNameOnForm.remove();
        }
        function replyToComment(commentId) {
            // this function is required to initialize the form fields
            let commentForm = document.getElementById('commentForm');
            let parentCommentIdInput = commentForm.querySelector('[name="parent_comment_id"]');

            let parentCommentName = document.getElementById('comment-' + commentId).getAttribute('data-creator');
            parentCommentIdInput.value = commentId;

            let replierNameOnCommentForm = commentForm.querySelector('#replier-name');
            if (replierNameOnCommentForm){
                replierNameOnCommentForm.remove();
            }

            let newReplierNameOnCommentForm = `
                <div class="input-group-prepend" id="replier-name">
                    <div class="input-group-text">
                        <a href="#comment-${commentId}" onclick="animationFindParentComment(this, event)" class="input-group-text answerTo badge btn badge-info">
                            @${parentCommentName}
                        </a>
                    </div>
                </div>`;

            commentForm.querySelector('[name="comment_text"]').insertAdjacentHTML('beforeBegin', newReplierNameOnCommentForm);
            $('html, body').animate({scrollTop: $(commentForm).offset().top}, 200);
        }

        function findRepliesList(childCommentId) {
            let childComment = document.getElementById('comment-'+childCommentId);
            //every comment is located in comment block and every comment block contain .replies-list
            return childComment.closest('.comment-block').querySelector('.replies-list')
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
                //result has parent_comment_id only if that comment is reply to another comment
                let parentCommentCreator = document.getElementById('comment-'+result.parent_comment_id).getAttribute('data-creator');
                let commentHtml = `
                    <li class="reply-comment-item" id="comment-${result.id}" data-creator="${result.creator}" data-parent-id="${result.parent_comment_id}">
                        <div class="comment-creator">
                            <b>${result.creator}</b>, ${createdAt}
                        </div>
                        <div class="comment-text">
                            <a href="#comment-${result.parent_comment_id}" onclick="animationFindParentComment(this, event)" class="answerTo badge btn badge-info">
                                @${parentCommentCreator}
                            </a>
                            ${result.comment}
                        </div>
                        <div class="comment-action">
                            <button onclick="replyToComment(${result.id})" id="answer" class="btn p-0 answer text-info">Reply</button>
                        </div>
                    </li>
                `;
                let repliesList = findRepliesList(result.parent_comment_id);
                repliesList.insertAdjacentHTML('beforeEnd', commentHtml);
                checkRepliesListDisplayAttr(result.id);
                return;
            }
            //If comment is not a reply than put it to the end of #comment list
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
                            <button onclick="replyToComment(${result.id})" id="answer" class="btn p-0 answer text-info">Reply</button>
                        </div>
                    </div>
                    <div class="replies" id="replies-${result.id}" data-basic-comment-id="${result.id}" style="display: none">
                        <ol class="replies-list" id="replies-list-${result.id}"></ol>
                    </div>
                </div>
            `;
            commentList.insertAdjacentHTML('beforeEnd', commentHtml);
        }
        function callback(token){
            //this func is called after user passes captcha
            return new Promise(function(resolve, reject) {
                let commentForm = document.querySelector('#commentForm');
                if (!commentForm) {
                    grecaptcha.reset();
                    reject('Can not find form');
                }
                let buttonSubmitButton = commentForm.querySelector('[type="submit"]');

                let formData = new FormData(commentForm);
                formData.append('g-recaptcha-response', token);
                $.ajax({
                    url: '{{ route('comment.store') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function (result) {
                        pasteComment(JSON.parse(result));
                    },
                    fail: function (result) {

                    }
                });
                grecaptcha.reset();
                resolve();
            });
        }
        function renderButton(buttonElement) {
            if (buttonElement.disabled === false) {
                buttonElement.disabled = true;
                buttonElement.innerHTML = `
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                `;
            } else {
                buttonElement.disabled = false;
                buttonElement.innerHTML = 'Create';
            }
        }
    </script>
@endpush
