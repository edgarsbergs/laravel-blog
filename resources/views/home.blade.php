@extends('layouts.app')
@section('content')
    @if ( !$posts->count() )
        Not posts
    @else
        <div class="">
            @foreach( $posts as $post )
                <div class="list-group">
                    <div class="list-group-item">
                        <h3><a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a>
                            @can('edit', $post)
                                <x-post-edit-buttons :post="$post"/>
                            @endcan
                        </h3>
                        <p>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->user_id)}}">{{ $post->author->name }}</a></p>
                    </div>
                    <div class="list-group-item">
                        <article>
                            {!! Str::limit($post->body, $limit = 300, $end = '....... <a href='.url("/".$post->slug).'>Read More</a>') !!}
                        </article>
                    </div>
                </div>
            @endforeach
            {!! $posts->render() !!}
        </div>
    @endif
@endsection
