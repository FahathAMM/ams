<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class ShippingService extends ServiceProvider
{
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->baseUrl = config('cpanel.api.base_url');
        $this->username = config('cpanel.api.username');
        $this->password = config('cpanel.api.password');
    }

    public function createShipment(array $shipmentData)
    {
        $createUrl = $this->baseUrl . 'ShippingAPI.V2/Shipping/Service_1_0.svc/json/CreateShipments';

        $response = Http::withOptions(
            ['verify' => base_path('public/assets/cacert.pem')]
        )->post($createUrl, $shipmentData);

        return $response->json();
    }
}
