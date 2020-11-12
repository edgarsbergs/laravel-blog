@extends('layouts/admin')
@section('title')
    Settings
@endsection
@section('content')
    @if(count($settings) > 0)
        <form action="{{ route('updateSettings') }}" method="post">
            @csrf
            @foreach ($settings as $setting)
                <div class="input-group mb-3">
                    <label for="{{ $setting->option }}">{{ $setting->option  }}</label>
                    <input type="text" class="form-control" name="{{ $setting->option }}" id="{{ $setting->option }}" value="{{ $setting->value }}"/>
                </div>
            @endforeach
            <input type="submit" name="update" class="btn btn-success" value="Update">
        </form>
    @endif
@endsection
