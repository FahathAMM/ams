<?php

namespace App\Http\Controllers\Pages\Order;

use Illuminate\Http\Request;
use App\Providers\ShippingService;
use App\Http\Controllers\Controller;
use App\Models\ImportOrder\ImportOrder;
use App\Models\ImportOrder\OrderCustomer;
use App\Models\ImportOrder\OrderGiftCard;
use App\Models\ImportOrder\OrderGiftCardDetail;
use App\Models\ImportOrder\OrderTax;

class ShipmentController extends Controller
{
    protected $modelName = 'Shipping';
    protected $routeName = 'role.index';
    protected $isDestroyingAllowed;
    protected $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    public function create(Request $request)
    {
        // return ImportOrder::with('products.items')->Get();
        // return OrderGiftCard::with('giftItems')->Get();

        return ImportOrder::with([
            'coupons',
            'customer',
            'billingAddress',
            'payment',
            'shipping',
            'gift.giftItems',
            'products',
            'tax' => ['appliedTaxes', 'itemAppliedTaxes'],
            'products' => ['items']
        ])->get();


        // Prepare shipment data
        $shipmentData = $this->prepareShipmentData($request);

        // Call the ShippingService to create the shipment
        $response = $this->shippingService->createShipment($shipmentData);

        return response()->json($response);
    }

    protected function prepareShipmentData(Request $request)
    {
        // Example values assignment
        $currentTimestamp = now()->timestamp * 1000; // Milliseconds

        return [
            "Shipments" => [
                [
                    "Reference1" => "Shipment Reference",
                    "Shipper" => [
                        "Reference1" => "Shipper Reference - TestName",
                        "AccountNumber" => $request->input('accountno'),
                        "PartyAddress" => [
                            "Line1" => "Test Shipper Address Line1 TestName",
                            "City" => "Dubai",
                            "PostCode" => "000000",
                            "CountryCode" => "AE"
                        ],
                        "Contact" => [
                            "PersonName" => "Test Shipper Name",
                            "PhoneNumber1" => "048707766",
                            "CellPhone" => "971556893100",
                            "EmailAddress" => "test@aramex.com"
                        ]
                    ],
                    "Consignee" => [
                        "PartyAddress" => [
                            "Line1" => "Test Consignee Address Line1",
                            "City" => "Dubai",
                            "StateOrProvinceCode" => "FU",
                            "CountryCode" => "AE"
                        ],
                        "Contact" => [
                            "PersonName" => "Test Consignee Name",
                            "PhoneNumber1" => "048707766",
                            "CellPhone" => "971556893100",
                            "EmailAddress" => "test@hotmail.com"
                        ]
                    ],
                    "ShippingDateTime" => "/Date($currentTimestamp)/",
                    "DueDate" => "/Date($currentTimestamp)/",
                    "Details" => [
                        "Dimensions" => [
                            "Length" => 0,
                            "Width" => 0,
                            "Height" => 0,
                            "Unit" => "CM"
                        ],
                        "ActualWeight" => [
                            "Unit" => "KG",
                            "Value" => 0.1
                        ],
                        "DescriptionOfGoods" => "Items",
                        "GoodsOriginCountry" => "AE",
                        "NumberOfPieces" => 1
                    ]
                ]
            ],
            "LabelInfo" => [
                "ReportID" => 9729,
                "ReportType" => "URL"
            ],

            "ClientInfo" => [
                "UserName" =>  config('cpanel.api.username'),
                "Password" => config('cpanel.api.Password'),
                "Version" => "v1.0",
                "AccountNumber" => config('cpanel.api.AccountNumber'),
                "AccountPin" => config('cpanel.api.AccountPin'),
                "AccountEntity" => "DXB",
                "AccountCountryCode" => "AE",
                "Source" => 0
            ]
        ];
    }
}
