@extends('layouts/admin')
@section('title')Posts @endsection
@section('after-title')
    <a href="{{ route('newPost') }}" class="btn-light">Add new</a>
@endsection
@section('content')
    @if(count($posts) > 0)
    <ul class="list-group">
        @foreach ($posts as $post)
            <li class="list-group-item"><a href="{{ route('admin/post', $post->id) }}">{{$post->title}}</a></li>
        @endforeach
    </ul>
    {{ $posts->links('vendor/pagination/bootstrap-4') }}
    @endif
@endsection
