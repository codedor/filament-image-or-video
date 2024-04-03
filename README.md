# Image or video field for Filament

Package to embed an image or youtube/vimeo as a Filament field

## Installation

You can install the package via composer:

```bash
composer require codedor/filament-image-or-video
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-image-or-video-views"
```

Optionally, you can publish the translations using

```bash
php artisan vendor:publish --tag="filament-image-or-video-translations"
```

## Usage

```php
$filamentImageOrVideo = new Codedor\FilamentImageOrVideo();
echo $filamentImageOrVideo->echoPhrase('Hello, Codedor!');
```

## Documentation

For the full documentation, check [here](./docs/index.md).

## Testing

```bash
vendor/bin/pest
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Upgrading

Please see [UPGRADING](UPGRADING.md) for more information on how to upgrade to a new version.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover any security-related issues, please email info@codedor.be instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
