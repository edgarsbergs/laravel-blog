@extends('layouts/admin')

@section('title')
    {{ __('admin.add_new_post') }}
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
    <form action="{{ route('storePost') }}" method="post">
        @csrf
        <div class="form-group">
            <input required="required" value="{{ old('title') }}" placeholder="{{ __('admin.enter_title') }}" type="text" name = "title"class="form-control" />
        </div>
        <div class="form-group">
            <textarea name='body'class="form-control">{{ old('body') }}</textarea>
        </div>
        <div class="mt-5">
            <input type="submit" name='publish' class="btn btn-success" value="{{ __('buttons.publish') }}"/>
            <input type="submit" name='save' class="btn btn-default" value="{{ __('buttons.save_draft') }}" />
        </div>
    </form>
@endsection
