<?php

namespace Codedor\FilamentImageOrVideo\Filament\Components;

use Codedor\MediaLibrary\Filament\AttachmentInput;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;

class ImageOrVideoUrl
{
    public static function make(
        bool $simpleOembed = false,
        ?array $attachmentFormats = null,
        string $prefix = '',
        bool $noVideo = false
    ): Group {
        $oembedClass = match ($simpleOembed) {
            true => SimpleOEmbed::class,
            false => OEmbed::class,
        };

        $options = [
            'image' => 'Image (Media library)',
            'video' => 'Video (Youtube/Vimeo)',
        ];

        if ($noVideo) {
            unset($options['video']);
        }

        return Group::make([
            Select::make($prefix . 'image_or_video')
                ->options($options)
                ->default('image')
                ->formatStateUsing(fn ($state) => $state ?? 'image')
                ->reactive(),

            $oembedClass::make($prefix . 'video')
                ->hidden(fn (Get $get) => $get($prefix . 'image_or_video') !== 'video')
                ->label('Video (Youtube/Vimeo)'),

            AttachmentInput::make($prefix . 'image_id')
                ->hidden(fn (Get $get) => ! in_array($get($prefix . 'image_or_video'), ['image', 'video']))
                ->label(fn (Get $get) => $get($prefix . 'image_or_video') === 'image' ? 'Image (Media library)' : 'Video Fallback Image (Media library)')
                ->allowedFormats($attachmentFormats ?? []),
        ]);
    }
}
