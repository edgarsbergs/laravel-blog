@extends('layouts/admin')
@section('title')
    Comments
@endsection
@section('content')
    @if(count($comments) > 0)
        <ul class="list-group">
            @foreach ($comments as $comment)
                <li class="list-group-item">
               <div><small>
                       <a href="{{ route('admin/user', $comment->author->id) }}">{{ $comment->author->name }}</a>
                       on post:
                       <a href="{{ route('admin/post', $comment->post->id) }}"> {{$comment->post->title}}</a>
                   </small>
               </div>
                {{$comment->body}}
                </li>
            @endforeach
        </ul>
        {{ $comments->links('vendor/pagination/bootstrap-4') }}
    @endif
@endsection
