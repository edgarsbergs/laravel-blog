@extends('layouts/admin')

@section('title')
{{ $post->title }}
@endsection

@section('after-title')
    <a href="{{ route('showPost', $post->slug) }}" class="btn-light">{{ __('buttons.view_post') }}</a>
@endsection

@section('content')
    <x-editor />
    <div class="row">
        <div class="col-lg-9 col-md-8">
            <form method="post" action='{{ route("updatePost") }}'>
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="form-group">
                    <input required="required" placeholder="{{ __('admin.enter_title') }}" type="text" name = "title" class="form-control"
                           value="@if(!old('title')){{$post->title}}@endif{{ old('title') }}"/>
                </div>
                <div class="form-group">
                    <textarea required name='body'class="form-control">
                      @if(!old('body'))
                            {!! $post->body !!}
                        @endif
                        {!! old('body') !!}
                    </textarea>
                </div>
                <!-- additional edit forms if post_type requires them -->
                @yield('content-edit-1')

                <div class="mt-5">
                    @if($post->active == 1)
                        <input type="submit" name='publish' class="btn btn-success" value = "{{ __('buttons.save') }}"/>
                    @else
                        <input type="submit" name='publish' class="btn btn-success" value = "{{ __('buttons.publish') }}"/>
                    @endif
                    <input type="submit" name='save' class="btn btn-default" value = "{{ __('buttons.save_and_continue') }}" />
                    @php
                    $deleteUrl = route('admin/deletePost', $post->id);
                    $deleteUrl .= '?_token='.csrf_token();
                    @endphp
                    <a href="{{ $deleteUrl }}" class="btn btn-danger float-right">{{ __('buttons.delete') }}</a>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin/sidebar', ['post' => $post])
        </div>
@endsection
