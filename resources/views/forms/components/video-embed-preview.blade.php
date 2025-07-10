@php
    $state = $getState();

    $params = [
        'autoplay' => $state['autoplay'] ? 1 : 0,
        'mute' => $state['mute'] ? 1 : 0,
        'loop' => $state['loop'] ? 1 : 0,
        'controls' => $state['controls'] ? 1 : 0,
    ];

    if (
        $state['embed_type'] === 'youtube'
        && strpos($state['url'], 'shorts')
    ) {
        $url = $state['url'];
        $id = substr($url, strrpos($url, '/') + 1);
        $state['embed_url'] = "https://www.youtube.com/embed/$id";
    }

    if ($state['embed_url'] && Str::contains($state['embed_url'], 'youtube')) {
        $videoId = Str::after($state['embed_url'], 'https://www.youtube.com/embed/');
        $params['playlist'] = $videoId;
    }
@endphp

<x-filament-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
    class="video-embed-preview"
>
    <div class="border border-gray-300 dark:border-gray-700 rounded-xl overflow-hidden aspect-video w-full h-auto bg-gray-300/30 dark:bg-gray-800/20">
        @if($state && $state['embed_url'])
            <iframe
                src="{{ $state['embed_url'] }}?{{ http_build_query($params) }}"
                width="640"
                height="360"
                allow="autoplay; fullscreen; picture-in-picture"
                allowfullscreen
                class="w-full h-full"
            ></iframe>
        @endif
    </div>
</x-filament-forms::field-wrapper>
