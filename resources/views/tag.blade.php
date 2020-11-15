@extends('layouts.app')

@section('content')
<h1>{{ __('frontend.posts_tagged') }} <i>{{ $tag->title }}</i></h1>
@if(count($posts) > 0)
    <ul>
        @foreach ($posts as $post)
            <li><a href="{{ route('showPost', $post->slug) }}">{{ $post->title }}</a></li>
        @endforeach
    </ul>
@endif
@endsection
