@extends('layouts.app')

@section('title')
    @if($post)
        {{ $post->title }}
    @endif
@endsection

@section('after-title')
    @can('edit', $post)
        <x-post-edit-buttons :post="$post"/>
    @endcan
@endsection

@section('title-meta')
    <div class="post-meta mb-4 small">
        {{ $post->created_at->format('M d,Y \a\t h:i a') }}
        By <a href="{{ url('/user/'.$post->user_id)}}">{{ $post->author->name }}</a>
        <x-tags :tags="$tags"/>
    </div>
@endsection

@section('content')
    @if($post)
        <article>
            {!! $post->body !!}
        </article>
        <h4>{{ __('frontend.leave_comment') }}</h4>
        @if(Auth::guest())
            <p>{{ __('frontend.login_to_comment') }}</p>
        @else
            <div>
                <form method="post" action="{{ route('addComment') }}">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="slug" value="{{ $post->slug }}">
                    <div class="form-group">
                        <textarea required="required" placeholder="{{ __('frontend.enter_comment') }}" name="body" class="form-control"></textarea>
                    </div>
                    <input type="submit" name='post_comment' class="btn btn-success" value="{{ __('buttons.post') }}"/>
                </form>
            </div>
        @endif
        @include('comments', ['comments' => $comments])
    @endif
@endsection
