<?php

namespace Codedor\FilamentImageOrVideo\Providers;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentImageOrVideoServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-image-or-video';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->setBasePath(__DIR__ . '/../')
            ->hasViews()
            ->hasAssets()
            ->hasTranslations();
    }
}
