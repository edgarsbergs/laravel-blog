@extends('layouts.app')
@section('content')
<h1>{{ __('frontend.profile') }} {{ $data['user']->name }}</h1>
    <p>{{ __('frontend.has_written', [
        'posts_count' => $data['posts_active_count'],
        'comments_count' => $data['comments_count'],
    ]) }}
    </p>
    @if(count($data['latest_posts']) > 0)
        <h4>{{ __('frontend.recent_posts') }}</h4>
        <ul>
            @foreach ($data['latest_posts'] as $post)
                <li><a href="{{ route('showPost', $post->slug) }}">{{ $post->title }}</a></li>
            @endforeach
        </ul>
    @endif

    @if(count($data['latest_comments']) > 0)
        <h4>{{ __('frontend.recent_comments') }}</h4>
        <ul>
            @foreach ($data['latest_comments'] as $comment)
                <li>{{ __('frontend.on_post') }}
                    <a href="{{ route('showPost', $comment->post->slug) }}">{{ $comment->post->title }}</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
