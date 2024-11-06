<?php

return [
    'fields' => [
        'name' => ['type' => 'string', 'length' => 191, 'required' => true, 'label'=>"lbl_name"],
        'email' => ['type' => 'string', 'length' => 191, 'required' => true, 'label'=>"lbl_email"],
        'password' => ['type' => 'string', 'length' => 191, 'required' => true, 'label'=>"lbl_password"],
    ],

    'allow_emails' => true,

    'enable_language_selector' => true,

    'supported_languages' => [
        'en' => 'English',
        'fr' => 'French'
    ],

    'email_service_url' => env('EMAIL_SERVICE_URL', 'https://service-discovery.dataforall.org/v1/catalog/service/dfa_mailer'),
];
