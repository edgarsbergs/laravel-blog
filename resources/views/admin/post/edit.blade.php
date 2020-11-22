@extends('admin/page/edit')

@section('content-edit-1')
    @include('admin/components/tags-form', ['tags' => $post->tags])
@endsection
