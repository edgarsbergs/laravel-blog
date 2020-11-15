@extends('layouts/admin')

@section('title')
    {{ __('admin.posts') }}
@endsection

@section('after-title')
    <a href="{{ route('newPost') }}" class="btn-light">{{ __('buttons.add_new') }}</a>
@endsection

@section('content')
    @if(count($posts) > 0)
    <ul class="list-group">
        @foreach ($posts as $post)
            <li class="list-group-item">
                <a href="{{ route('admin/post', $post->id) }}">{{ $post->title }}</a>
                {!! $post->active == 0 ? '<small>' . __('admin.unpublished') . '</small>' : '' !!}
            </li>
        @endforeach
    </ul>
    {{ $posts->links('vendor/pagination/bootstrap-4') }}
    @endif
@endsection
