<?php

namespace State\S3SignedRoute;

use Aws\Credentials\Credentials;
use Aws\S3\S3Client;
use Illuminate\Http\Request;

class CreateSignedRouteAction
{
    public function __invoke(Request $request, S3Signatory $signatory)
    {
        $request->validate([
            'filename'    => 'required',
            'contentType' => 'required'
        ]);

        $signedRequest = $signatory->signRequest(
            $request->input('filename'),
            $request->input('contentType'),
            $request->input('directory'),
        );

        return response()->json([
            'method'  => $signedRequest->getMethod(),
            'url'     => (string) $signedRequest->getUri(),
            'fields'  => [],
            'headers' => [
                'content-type' => $request->input('contentType'),
            ],
        ]);
    }
}