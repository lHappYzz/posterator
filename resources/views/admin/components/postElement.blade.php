<a href="{{route('post.show', ['post' => $post->slug])}}" class="list-group-item bg-light list-group-item-action">
    <h4 class="mb-1 post-title">{{$post->title}}</h4>
    <div class="postInfo font-weight-light">
        <p><span class="createdAt"><i class="fa fa-calendar"></i> {{ $post->created_at->format('M d Y, H:i') }}</span>
            <span class="commentsCount"><i class="fa fa-comments"></i> {{ $post->comments->count() }}</span></p>
    </div>
    <p class="mb-1">{{$post->shortDesc(130)}}</p>
</a>
