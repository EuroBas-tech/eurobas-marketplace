<?php

use App\Model\BusinessSetting;

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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_SERVICE_CALLBACK'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_SERVICE_CALLBACK'),
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => env('TWITTER_SERVICE_CALLBACK'),
    ],

    'apple' => [
        'client_id' => 'com.eurobas.web.login',
        'team_id' => '975WJJG233',
        'key_id' => '3K94UW8UQW',
        'private_key' => "-----BEGIN PRIVATE KEY-----\nMIGTAgEAMBMGByqGSM49AgEGCCqGSM49AwEHBHkwdwIBAQQgLndok/+oommuz4HswvitFx1aPex0obcyXmbSv64PTDigCgYIKoZIzj0DAQehRANCAAQDYozC+TMlGhKr8xEI+GLMLdxT5F2xd521DuyekNldGPM9eByN9anaWt71OwWiW1dVwfTt4SlpoLvNZRAsJ2oY\n-----END PRIVATE KEY-----",
        'redirect' => 'https://eurobas.com',
    ]
    
];
