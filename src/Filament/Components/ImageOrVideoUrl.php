<?php

namespace Codedor\FilamentImageOrVideo\Filament\Components;

use Codedor\MediaLibrary\Filament\AttachmentInput;
use Filament\Forms\Components\Select;

class ImageOrVideoUrl
{
    public static function make(
        bool $simpleOembed = false,
        ?array $attachmentFormats = null,
        string $prefix = '',
        bool $noVideo = false
    ): \Filament\Schemas\Components\Group {
        $oembedClass = match ($simpleOembed) {
            true => SimpleVideoEmbed::class,
            false => VideoEmbed::class,
        };

        $options = [
            'image' => __('filament-image-or-video::image-or-video.image option'),
            'video' => __('filament-image-or-video::image-or-video.video option'),
        ];

        if ($noVideo) {
            unset($options['video']);
        }

        return \Filament\Schemas\Components\Group::make([
            Select::make($prefix . 'image_or_video')
                ->label(__('filament-image-or-video::image-or-video.select label'))
                ->options($options)
                ->default('image')
                ->formatStateUsing(fn ($state) => $state ?? 'image')
                ->reactive(),

            $oembedClass::make($prefix . 'video')
                ->hidden(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get($prefix . 'image_or_video') !== 'video')
                ->label(__('filament-image-or-video::image-or-video.video option')),

            AttachmentInput::make($prefix . 'image_id')
                ->hidden(fn (\Filament\Schemas\Components\Utilities\Get $get) => ! in_array($get($prefix . 'image_or_video'), ['image', 'video']))
                ->allowedFormats($attachmentFormats ?? [])
                ->label(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get($prefix . 'image_or_video') === 'image'
                    ? __('filament-image-or-video::image-or-video.image option')
                    : __('filament-image-or-video::image-or-video.video fallback')
                ),

        ]);
    }
}
