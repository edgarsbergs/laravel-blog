@extends('layouts/admin')

@section('title')
    {{ __("admin.add_new_$post_type") }}
@endsection

@section('content')
    <x-editor />
    <form action="{{ route('storePost') }}" method="post">
        @csrf
        <div class="form-group">
            <input required="required" value="{{ old('title') }}" placeholder="{{ __('admin.enter_title') }}" type="text" name = "title"class="form-control" />
        </div>
        <div class="form-group">
            <textarea name='body'class="form-control">{{ old('body') }}</textarea>
        </div>

        <!-- additional edit forms if post_type requires them -->
        @yield('content-edit-1')

        <div class="mt-5">
            <input type="submit" name='publish' class="btn btn-success" value="{{ __('buttons.publish') }}"/>
            <input type="submit" name='save' class="btn btn-default" value="{{ __('buttons.save_draft') }}" />
        </div>
    </form>
@endsection
