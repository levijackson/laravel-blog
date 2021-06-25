<li>
    <div>
        <h4>{{ $comment->author()->first()->name }} <small>({{ date('Y-m-d', strtotime($comment->created_at)) }})</small></h4>
        <p>{{ $comment->comment }}</p>
    </div>
</li>