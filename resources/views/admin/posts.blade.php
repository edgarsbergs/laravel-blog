@extends('layouts/admin')
@section('title')
    Posts
@endsection
@section('content')
    <ul class="list-group">
        @foreach ($posts as $post)
            <li class="list-group-item"><a href="{{ route('admin/post', $post->id) }}">{{$post->title}}</a></li>
        @endforeach
    </ul>
@endsection
