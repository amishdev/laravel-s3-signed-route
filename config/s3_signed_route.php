<?php

return [
    'disk' => 's3',

    'default_directory' => 'uploads',

    // determines how long it takes for the pre-signed url to expire.
    'expiration' => '+10 minutes',
];