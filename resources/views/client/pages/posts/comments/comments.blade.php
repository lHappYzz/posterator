    @foreach($comments as $comment)
        <div class="comment-block">
            <div class="comment-item" id="comment-{{$comment->id}}" data-creator="{{$comment->creator->name}}">
                <div class="comment-creator">
                    <b>{{$comment->creator->name}}</b>, {{$comment->created_at->format('M d Y, H:i')}}
                </div>
                <div class="comment-text">
                    {!! $comment->comment !!}
                </div>
                <div class="comment-action" id="comment-action-{{ $comment->id }}">
                    <button onclick="replyToComment({{$comment->id}})" id="answer" class="btn p-0 answer text-info">Reply</button>
                    @if($comment->child_comments->count() > 0)
                        <button class="btn p-0 text-secondary show-more-answers" onclick="showAnswers(this, {{$comment->id}})" id="showMoreAnswer-{{$comment->id}}">Show answers</button>
                    @endif
                </div>
            </div>
            <div class="replies" id="replies-{{$comment->id}}" data-basic-comment-id="{{$comment->id}}" style="display: none">
                <ol class="replies-list" id="replies-list-{{$comment->id}}">
                    @include('client.pages.posts.comments.subcomments', [
                               'parent_comment' => $comment,
                               'basic_comment_id' => $comment->id,
                           ])
                </ol>
            </div>
        </div>

    @endforeach
