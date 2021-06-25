@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>

        <p>{{ $post->body }}</p>

        <h3>Comments</h3>
        @include('blog.comments.create')

        <br /><br />
        <ul class="comment-list">
        @foreach ($comments as $comment)
            @include('blog.comments.single')
        @endforeach
        </ul>
    </div>
@stop