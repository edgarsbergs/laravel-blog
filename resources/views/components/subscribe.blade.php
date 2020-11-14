<h4>{{ __('frontend.subscribe_heading') }}</h4>
<form action="{{ route('subscribe') }}" method="post">
    @csrf
    <input required type="email" name="email" class="form-control">
    <input type="submit" name="subscribe" class="btn btn-success mt-2" value="{{ __('buttons.subscribe') }}">
</form>
