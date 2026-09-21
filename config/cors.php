<?php
 
return [
'paths' => ['api/*'],
'allowed_methods' => ['*'],
'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:5173')],
'allowed_headers' => ['*'],
'supports_credentials' => false,

    'max_age' => 0,
    // 'supports_credentials' => true, // Must be true for Sanctum cookies
];