@extends('layouts.app')

@section('content')
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/admin/blog/post/{{ $post->slug }}" method="post" class="container">
        <input type="hidden" name="_method" value="PUT">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value={{ $post->title }} />
        </div>
        <div class="form-group">
            <label for="metaTitle">Meta Title</label>
            <input type="text" name="metaTitle" class="form-control" value={{ $post->metaTitle }}  />
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea name="body" class="form-control">{{ $post->body }}</textarea>
        </div>
        <div class="form-group">
            <label for="metaDescription">Meta Description</label>
            <textarea name="metaDescription" class="form-control">{{ $post->metaDescription }}</textarea>
        </div>
        <div class="form-group">
            <label for="slug">URL Slug (optional)</label>
            <small>If not specified one will be created from the title</small>
            <input type="text" name="slug" class="form-control" value={{ $post->slug }} />
        </div>
        <input type="submit" name="update" class="btn btn-success" value="Update" />
        <input type="submit" name="delete" class="btn btn-danger" value="Delete" />
    </form>
@stop