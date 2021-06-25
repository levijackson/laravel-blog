@extends('layouts.app')

@section('content')
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form action="/admin/blog/post" method="post" class="container">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" />
        </div>
        <div class="form-group">
            <label for="metaTitle">Meta Title</label>
            <input type="text" name="metaTitle" class="form-control" />
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea name="body" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="metaDescription">Meta Description</label>
            <textarea name="metaDescription" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="urlSlug">URL Slug (optional)</label>
            <small>If not specified one will be created from the title</small>
            <input type="text" name="urlSlug" class="form-control" />
        </div>
        <input type="submit" name="publish" class="btn btn-success" value="Publish" />
        <input type="submit" name="draft" class="btn btn-default" value="Save Draft" />
    </form>
@stop