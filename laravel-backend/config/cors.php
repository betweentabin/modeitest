<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login'],

    'allowed_methods' => ['*'],

    // Exact origins (no wildcards). For production, set CORS_ALLOWED_ORIGINS env, comma-separated.
    'allowed_origins' => array_filter(array_map('trim', explode(',', (string) env('CORS_ALLOWED_ORIGINS', 'http://localhost:3000,http://localhost:8080,http://localhost:5173,https://modeitest.vercel.app')))),

    // Regex patterns for dynamic subdomains (works with credentials as the matched origin is echoed back)
    'allowed_origins_patterns' => array_filter(array_map(function ($p) { return trim($p); }, explode(',', (string) env('CORS_ALLOWED_ORIGIN_PATTERNS', '/^https:\/\/.*\.vercel\.app$/,/^https:\/\/.*\.railway\.app$/')))),

    // Be explicit for some proxies that dislike '*'
    'allowed_headers' => array_filter(array_map('trim', explode(',', (string) env('CORS_ALLOWED_HEADERS', 'Accept,Authorization,Content-Type,Origin,X-Requested-With')))),

    'exposed_headers' => array_filter(array_map('trim', explode(',', (string) env('CORS_EXPOSED_HEADERS', 'Authorization,X-RateLimit-Limit,X-RateLimit-Remaining,X-Request-Id')))),

    // ブラウザにプリフライト結果をキャッシュさせ、不要なOPTIONSを減らす
    'max_age' => (int) env('CORS_MAX_AGE', 600),

    'supports_credentials' => (bool) env('CORS_SUPPORTS_CREDENTIALS', true),

];
