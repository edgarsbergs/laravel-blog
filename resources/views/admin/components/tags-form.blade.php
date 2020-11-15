@section('scripts')
    <link href="{{ asset('/css/magicsuggest-min.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/magicsuggest-min.js') }}"></script>
@endsection

<h4>Tags</h4>
<input id="tags" name="tags">
<script>
    $(function() {
        $('#tags').magicSuggest({

        });
    });
</script>
