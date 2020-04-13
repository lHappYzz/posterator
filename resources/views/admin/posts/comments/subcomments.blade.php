@php
    $subcomments = $parent_comment->child_comments ?? false;
@endphp
@if($subcomments)
    @php $counter++ @endphp
    <ol class="subcomment-list" id="subcomment-list-{{$parent_comment->id}}@if($counter > 3) limited @endif">
    @foreach($subcomments as $comment)
        <li class="comment-tree-item">
            <div class="comment-item">
                <div class="comment-creator">
                    <b>{{$comment->creator->name}}</b>, {{$comment->created_at->format('M d Y, H:i')}}
                </div>
                <div class="comment-text">
                    {!! $comment->comment !!} {{--comment text--}}
                </div>
                <div class="comment-action">
                    <span onclick="showCommentForm({{$comment->id}})" id="answer" class="answer text-info">Reply</span>
                    @if($comment->child_comments->count() > 0)
                        <span class="text-secondary" onclick="showAnswers(this, {{$comment->id}})" id="showMoreAnswer">Show answers</span>
                    @endif
                </div>
                <div class="comment-answers" id="commentAnswers{{$comment->id}}" style="display: none">
                    @include('admin.posts.comments.subcomments', [
                            'parent_comment' => $comment,
                        ])
                </div>
            </div>
        </li>
    @endforeach
    </ol>
@endif
