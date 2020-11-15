@extends('layouts/admin')

@section('title')
    {{ $post->title }}
@endsection

@section('content')
    <script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript">
        tinymce.init({
            selector : "textarea",
            plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste"],
            toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
    </script>
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

                @include('admin/components/tags-form')

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
