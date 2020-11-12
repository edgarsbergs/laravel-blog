@extends('layouts/admin')
@section('title')
    Users
@endsection
@section('content')
    @foreach ($users as $user)
        <a href="{{ route('admin/user', $user->id) }}">{{$user->name}}</a>
    @endforeach
@endsection
