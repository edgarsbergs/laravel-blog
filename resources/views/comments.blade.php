@if($comments)
    <div class="mt-4">
        <ul class="list-group">
            @foreach($comments as $comment)
                <li class="list-group-item">
                    <strong>{{ $comment->author->name }}</strong>
                    <div class="small">{{ $comment->created_at->format('M d,Y \a\t h:i a') }}</div>
                    <div>{{ $comment->body }}</div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
