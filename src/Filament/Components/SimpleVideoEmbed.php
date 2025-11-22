<?php

namespace Codedor\FilamentImageOrVideo\Filament\Components;

use Filament\Forms;
use Illuminate\Support\Str;

class SimpleVideoEmbed extends VideoEmbed
{
    public static function make(string $field = 'video'): \Filament\Schemas\Components\Fieldset
    {
        return \Filament\Schemas\Components\Fieldset::make($field)
            ->label(fn (): string => Str::of($field)->title())
            ->schema([
                \Filament\Schemas\Components\Group::make([
                    Forms\Components\Hidden::make($field . '.embed_url'),
                    Forms\Components\Hidden::make($field . '.embed_type')
                        ->default('youtube'),
                    static::urlInput($field),
                    Forms\Components\Checkbox::make($field . '.responsive')
                        ->default(true)
                        ->hidden(),
                    Forms\Components\TextInput::make($field . '.width')
                        ->default('16')
                        ->hidden(),
                    Forms\Components\TextInput::make($field . '.height')
                        ->default('9')
                        ->hidden(),
                    Forms\Components\Checkbox::make($field . '.autoplay')
                        ->default(false)
                        ->hidden(),
                    Forms\Components\Checkbox::make($field . '.loop')
                        ->default(false)
                        ->hidden(),
                    Forms\Components\Checkbox::make($field . '.show_title')
                        ->default(false)
                        ->hidden(),
                    Forms\Components\Checkbox::make($field . '.byline')
                        ->default(false)
                        ->hidden(),
                    Forms\Components\Checkbox::make($field . '.portrait')
                        ->default(false)
                        ->hidden(),
                    Forms\Components\Checkbox::make($field . '.mute')
                        ->default(false)
                        ->hidden(),
                    Forms\Components\Checkbox::make($field . '.controls')
                        ->default(false)
                        ->hidden(),

                    static::videoPreview($field),
                ]),

            ]);
    }
}
