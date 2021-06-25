<form action="/admin/blog/comment" method="post" class="container">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="post_id" value={{ $post->id }} />
    <div class="form-group">
        <label for="comment">Comment</label>
        <textarea name="comment" class="form-control"></textarea>
    </div>
    <input type="submit" name="submit" class="btn btn-success" value="Comment" />
</form>
