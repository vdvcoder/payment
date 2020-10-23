<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    "currency" => 'EUR',

    "mollie" => [
        "test_key" => env('MOLLIE_TEST_KEY'),
        "prod_key" => env('MOLLIE_PROD_KEY'),
    ]
];
