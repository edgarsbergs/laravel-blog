@extends('layouts/admin')
@section('title')
    Comments
@endsection
@section('content')
    @foreach ($comments as $comment)
       <div><small>On post:  {{$comment->post->title}}</small></div>
        {{$comment->body}}
        <hr />
    @endforeach
@endsection
