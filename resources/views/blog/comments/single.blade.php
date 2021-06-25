<li>
    <div>
        <h4>{{ $comment->author()->first()->name }} <small>({{ date('Y-m-d', strtotime($comment->created_at)) }})</small></h4>
        <p>{{ $comment->comment }}</p>
        @auth
            <form action="/admin/blog/comment/{{ $comment->id }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="_method" value="DELETE">
                <input type="submit" name="delete" class="btn btn-danger" value="Delete" />
            </form>
        @endauth
    </div>
</li>