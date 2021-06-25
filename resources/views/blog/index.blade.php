@extends('layouts.app')

@section('content')
    <h1>{{$title}}</h1>
    @forelse ($posts as $post)
        @guest
            <li>{{ $post->title }}</li>
        @endguest
        @auth
            <li>{{ $post->title }} - <a href="/blog/post/{{ $post->slug }}">View</a> | <a href="/admin/blog/post/{{ $post->slug }}">Edit</a></li>
        @endauth
    @empty
        <p>No posts</p>
    @endforelse
@stop