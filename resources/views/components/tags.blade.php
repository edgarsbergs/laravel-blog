@if(count($tags) > 0)
    <div class="tags">{{ __('frontend.tags') }}
    @foreach ($tags as $tag)
        <a href="{{ route('showTag', $tag->slug) }}" class="tag">
            {{ $tag->title }}
        </a>
    @endforeach
    </div>
@endif
