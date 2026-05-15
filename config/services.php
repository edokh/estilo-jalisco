<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'vonage' => [
        'application_id' => env('VONAGE_APPLICATION_ID'),
        'private_key' => env('VONAGE_PRIVATE_KEY'),
        'api_url' => env('VONAGE_API_URL', 'https://messages-sandbox.nexmo.com/v1/messages'),
    ],

    'whatsapp' => [
        'from_number' => env('WHATSAPP_FROM_NUMBER'),
        'restaurant_number' => env('WHATSAPP_RESTAURANT_NUMBER'),
        'send_customer' => env('WHATSAPP_SEND_CUSTOMER', false),
    ],
];
