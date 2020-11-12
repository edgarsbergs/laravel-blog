@extends('layouts/admin')
@section('title')
    Settings
@endsection
@section('content')
    <form action="">
    @foreach ($settings as $setting)
        <label for="{{ $setting->option }}">{{ $setting->option  }}</label>
        <input type="text" class="form-control" name="{{ $setting->option }}" id="{{ $setting->option }}" value="{{ $setting->value }}"/>
    @endforeach
    </form>
@endsection
