@extends('layouts/admin')
@section('title')
    Dashboard
@endsection
@section('content')
    Hello, your site has <strong>{{$postsCount}}</strong> <a href="{{ route('admin/posts') }}">posts</a> with <strong>{{$commentsCount}}</strong> <a href="{{ route('admin/comments') }}">comments</a><br />
    <h3>Design</h3>
    <a href="{{ route('admin/menus') }}">Change menus</a>
    <h3>Settings</h3>
    <a href="{{ route('admin/settings') }}">Change settings</a>
@endsection
