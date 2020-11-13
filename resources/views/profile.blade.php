@extends('layouts.app')
@section('content')
<h1>Profile: {{ $data['user']->name }}</h1>
    <p>Has written {{ $data['posts_active_count'] }} posts and {{ $data['comments_count'] }} comments</p>
    @if(count($data['latest_posts']) > 0)
        <h4>Recent posts</h4>
        <ul>
            @foreach ($data['latest_posts'] as $post)
                <li><a href="{{ route('showPost', $post->slug) }}">{{ $post->title }}</a></li>
            @endforeach
        </ul>
    @endif

    @if(count($data['latest_comments']) > 0)
        <h4>Recent comments</h4>
        <ul>
            @foreach ($data['latest_comments'] as $comment)
                <li>On post: <a href="{{ route('showPost', $comment->post->slug) }}">{{ $comment->post->title }}</a></li>
            @endforeach
        </ul>
    @endif
@endsection
