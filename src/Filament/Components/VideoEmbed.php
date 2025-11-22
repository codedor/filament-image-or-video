<?php

namespace Codedor\FilamentImageOrVideo\Filament\Components;

use Filament\Forms;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\Str;

class VideoEmbed
{
    public static function make(string $field = 'video'): \Filament\Schemas\Components\Fieldset
    {
        return \Filament\Schemas\Components\Fieldset::make($field)
            ->label(fn (): string => Str::of($field)->title())
            ->schema([
                \Filament\Schemas\Components\Group::make([
                    Forms\Components\Hidden::make($field . '.embed_url'),
                    Forms\Components\Hidden::make($field . '.embed_type')
                        ->default('youtube')
                        ->formatStateUsing(fn (mixed $state) => $state ?? 'youtube'),
                    static::urlInput($field),
                    \Filament\Schemas\Components\Fieldset::make('Main options')
                        ->schema([
                            \Filament\Schemas\Components\Grid::make(['md' => 2])
                                ->schema([
                                    \Filament\Schemas\Components\Group::make([
                                        Forms\Components\Checkbox::make($field . '.loop')
                                            ->default(true)
                                            ->label(fn (): string => __('filament-image-or-video::image-or-video.loop'))
                                            ->reactive()
                                            ->formatStateUsing(fn (mixed $state) => $state ?? true),

                                        Forms\Components\Checkbox::make($field . '.autoplay')
                                            ->default(true)
                                            ->label(fn (): string => __('filament-image-or-video::image-or-video.autoplay'))
                                            ->reactive()
                                            ->formatStateUsing(fn (mixed $state) => $state ?? true)
                                            ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set, $state) => $set($field . '.mute', $state)),
                                    ]),

                                    \Filament\Schemas\Components\Group::make([
                                        Forms\Components\Checkbox::make($field . '.controls')
                                            ->default(false)
                                            ->formatStateUsing(fn (mixed $state) => $state ?? false)
                                            ->label(fn (): string => __('filament-image-or-video::image-or-video.controls'))
                                            ->reactive(),

                                        Forms\Components\Checkbox::make($field . '.mute')
                                            ->default(true)
                                            ->formatStateUsing(fn (mixed $state) => $state ?? true)
                                            ->label(fn (): string => __('filament-image-or-video::image-or-video.mute'))
                                            ->reactive()
                                            ->disabled(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get($field . '.autoplay')),
                                    ]),

                                    TextEntry::make('placeholder')
                                        ->hidden(fn (\Filament\Schemas\Components\Utilities\Get $get) => ! $get($field . '.autoplay'))
                                        ->label(fn () => __('filament-image-or-video::image-or-video.video muted description'))
                                        ->columnSpan(2),
                                ]),
                        ]),
                ]),
                static::videoPreview($field),
            ]);
    }

    public static function getVimeoUrl(string $url): string
    {
        if (Str::of($url)->contains('/video/')) {
            return $url;
        }

        preg_match('/\.com\/([0-9]+)/', $url, $matches);

        if (! $matches || ! $matches[1]) {
            return '';
        }

        $outputUrl = "https://player.vimeo.com/video/{$matches[1]}";

        return $outputUrl;
    }

    public static function getYoutubeUrl(string $url): string
    {
        if (Str::of($url)->contains('/embed/')) {
            return $url;
        }

        if (preg_match('#youtu\.be/([a-zA-Z0-9_-]+)#i', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        preg_match('/v=([-\w]+)/', $url, $matches);

        if (! $matches || ! $matches[1]) {
            return '';
        }

        $outputUrl = "https://www.youtube.com/embed/{$matches[1]}";

        return $outputUrl;
    }

    protected static function urlInput(string $field): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make($field . '.url')
            ->label(fn (): string => __('filament-image-or-video::image-or-video.url'))
            ->reactive()
            ->lazy()
            ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get, $state) use ($field) {
                if ($state) {
                    $embedType = Str::of($state)->contains('vimeo') ? 'vimeo' : 'youtube';

                    if ($embedType === 'vimeo') {
                        $embedUrl = static::getVimeoUrl($state);
                    } else {
                        $embedUrl = static::getYoutubeUrl($state);
                    }

                    $set($field . '.embed_url', $embedUrl);
                    $set($field . '.embed_type', $embedType);
                } else {
                    $set($field . '.embed_url', null);
                    $set($field . '.embed_type', null);
                }
            })
            ->columnSpan('full');
    }

    protected static function videoPreview(string $field): Forms\Components\ViewField
    {
        return Forms\Components\ViewField::make($field)
            ->view('filament-image-or-video::forms.components.video-embed-preview')
            ->label(fn (): string => __('filament-image-or-video::image-or-video.preview'));
    }
}
