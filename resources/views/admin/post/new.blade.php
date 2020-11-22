@extends("admin/page/new")

@section('title')
    {{ __("admin.add_new_$post_type") }}
@endsection

@section('content-edit-1')
    @include('admin/components/tags-form', [])
@endsection
