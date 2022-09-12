<?php
return [
    'Zarrinpal' => [
        'id' => 1,
        'class' => 'Zarrinpal',
        'base_url' => 'https://sandbox.zarinpal.com/pg',
        'merchant_id' => \Illuminate\Support\Str::random(36),
        'icon' => '/uploads/zarinpal-logo.png',
        'name' => 'زرین پال',
        'default' => false,
        'active' => env('GATEWAY_SANDBOX_ACTIVE', false),
    ],
    'IranKish' => [
        'id' => 2,
        'class' => 'IranKish',
        'base_url' => 'https://ikc.shaparak.ir',
        'merchant_id' => '08119915',
        'password' => '26B76F0D7067954B',
        'acceptor_id' => '992180008119915',
        'icon' => '/uploads/irankish_logo.jpg',
        'pub_key' => '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCs3nw39BbiDgRbSoIS9E+ttoJj
Pi9e6hmNy60qoClILbWBrtYPtWywaB577z7UlSaFLyTVnzjbWgOsHlnHQeXvDqAb
Za3M9KKhZztcyufd6DrQ6zPGNgcH1/1EDxVh4lTJJDaezN1eFoP/BvtY66lIUj+f
xBcJ82Eia4JB0VdklQIDAQAB
-----END PUBLIC KEY-----',
        'name' => 'ایران‌کیش',
        'active' => true,
        'default' => true,
    ]
];