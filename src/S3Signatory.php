<?php

namespace State\S3SignedRoute;

use Aws\Credentials\Credentials;
use Aws\S3\S3Client;

class S3Signatory
{
    public function signRequest(string $filename, string $contentType, string $directory = null)
    {
        $directory ??= config('s3_signed_route.default_directory');

        $disk = config('filesystems.disks.' . config('s3_signed_route.disk'));

        $endpoint    = $disk['endpoint'];
        $region      = $disk['region'];
        $bucket      = $disk['bucket'];
        $credentials = new Credentials($disk['key'], $disk['secret']);

        $s3 = new S3Client([
            'version'     => 'latest',
            'credentials' => $credentials,
            'endpoint'    => $endpoint,
            'region'      => $region,
        ]);

        $command = $s3->getCommand('putObject', [
            'Bucket'      => $bucket,
            'Key'         => "{$directory}/{$filename}",
            'ContentType' => $contentType,
            'Body'        => '',
        ]);

        return $s3->createPresignedRequest(
            $command,
            config('s3_signed_route.expiration', '+10 minutes')
        );
    }

}