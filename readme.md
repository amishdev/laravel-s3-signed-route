# S3SignedRoute

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]

[//]: # ([![StyleCI][ico-styleci]][link-styleci])

Use to securely upload directly to a s3 bucket from your frontend. This package was designed to upload to s3 with [Uppy](https://uppy.io/docs/aws-s3/#Generating-a-presigned-upload-URL-server-side) but it could be used with other libraries.



## Installation

Via Composer

``` bash
composer require amish/laravel-s3-signed-route
```

## Usage

Register the s3 signing route with the macro, then apply the middleware, etc.
The route is registered with the name 's3-signed-route'.
```php
Route::signedS3Route()->middleware(['auth', ...]);
```
### Usage with Uppy
```javascript
let uppy = new Uppy({
    allowMultipleUploads: false,
    debug: true,
    restrictions: {
        allowedFileTypes: ['*'],
        maxNumberOfFiles: 1,
        minNumberOfFiles: 1,
    },
}).use(AwsS3, {
    getUploadParameters: (file) => {
        // Send a request to our signing endpoint. route('s3-signed-route')
        return fetch(signingEndpoint, {
            method: 'post',
            // Send and receive JSON.
            headers: {
                accept: 'application/json',
                'content-type': 'application/json',
            },
            body: JSON.stringify({
                filename: file.name,
                contentType: file.type,
                directory: 'uploads',
                _token: document.querySelector('[name=csrf-token]').content,
            }),
        })
        .then(response => response.json())
        .then(data => {
            // Return an object in the correct shape.
            return {
                method: data.method,
                url: data.url,
                fields: data.fields,
                // Provide content type header required by S3
                headers: {
                    'Content-Type': file.type,
                },
            }
        })
    },
});
```
Refer to [Uppy's docs](https://uppy.io/docs/) for more configuration options.


## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author@email.com instead of using the issue tracker.

## Credits

- [Author Name][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/state/s3signedroute.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/state/s3signedroute.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/state/s3signedroute/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/state/s3signedroute
[link-downloads]: https://packagist.org/packages/state/s3signedroute
[link-travis]: https://travis-ci.org/state/s3signedroute
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/state
[link-contributors]: ../../contributors
