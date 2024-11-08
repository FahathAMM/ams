<?php

$baseUrl = 'https://ws.sbx.aramex.net/';


return [

    /*
    |--------------------------------------------------------------------------
    | Organization Module
    |--------------------------------------------------------------------------
    */
    'api' => [
        'base_url' => $baseUrl,
        'username' => env('SHIP_API_USERNAME'),
        'password' => env('SHIP_API_PASSWORD'),
    ],

    'clientInfo' => [
        "UserName" => "testingapi@aramex.com",
        "Password" => 'R123456789$r',
        'AccountNumber' => 45796,
        'AccountPin' => 116216,
    ],


    // "ClientInfo": {
    //         "UserName": "testingapi@aramex.com",
    //         "Password": "R123456789$r",
    //         "Version": "v1.0",
    //         "AccountNumber": "45796",
    //         "AccountPin": "116216",
    //         "AccountEntity": "DXB",
    //         "AccountCountryCode": "AE",
    //         "Source": 24,
    //         "PreferredLanguageCode": null
    //     }

];
