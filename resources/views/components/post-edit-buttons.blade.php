<span class="float-right">
    @if($post->active == '1')
        <a href="{{ route('admin/post', $post->id) }}" class="btn-light">{{ __('buttons.edit_post') }}</a>
    @else
        <a href="{{ route('admin/post', $post->id) }}" class="btn-light">{{ __('buttons.edit_draft') }}</a>
    @endif
</span>
