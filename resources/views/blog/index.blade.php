@extends('layouts.app')

@section('content')
    <h1>{{$title}}</h1>
    @forelse ($posts as $post)
        <li>{{ $post->title }}</li>
    @empty
        <p>No posts</p>
    @endforelse
@stop