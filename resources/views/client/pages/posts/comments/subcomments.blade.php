@php
    $subcomments = $parent_comment->child_comments ?? false;
@endphp
@if($subcomments)
    @foreach($subcomments as $comment)
        <li class="reply-comment-item" id="comment-{{$comment->id}}" data-basic-comment-id="{{$basic_comment_id}}" data-creator="{{$comment->creator->name}}" data-parent-id="{{$parent_comment->id}}">
            <div class="comment-creator">
                <b>{{$comment->creator->name}}</b>, {{$comment->created_at->format('M d Y, H:i')}}
            </div>
            <div class="comment-text">
                <a href="#comment-{{$parent_comment->id}}" onclick="animationFindParentComment(this, event)" class="badge badge-info">
                    {{ '@' . $parent_comment->creator->name}}
                </a>
                {!! $comment->comment !!} {{--comment text--}}
            </div>
            <div class="comment-action">
                <span onclick="showCommentForm({{$comment->id}})" id="answer" class="answer text-info">Reply</span>
            </div>

        </li>
        @include('client.pages.posts.comments.subcomments', [
                    'parent_comment' => $comment,
                    'basic_comment_id' => $basic_comment_id,
                ])
    @endforeach
@endif
