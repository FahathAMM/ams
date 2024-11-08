<?php

namespace App\Http\Controllers\Pages\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\ImportOrder\OrderTax;
use Illuminate\Support\Facades\Http;
use App\Models\ImportOrder\ImportOrder;
use App\Models\ImportOrder\OrderCoupon;
use App\Models\ImportOrder\OrderPayment;
use App\Models\ImportOrder\OrderProduct;
use App\Models\ImportOrder\OrderCustomer;
use App\Models\ImportOrder\OrderGiftCard;
use App\Models\ImportOrder\OrderShipping;
use App\Models\ImportOrder\OrderAdjustment;
use App\Models\ImportOrder\OrderAppliedTax;
use App\Models\ImportOrder\OrderProductItem;
use App\Models\ImportOrder\OrderBillingAddress;
use App\Models\ImportOrder\OrderGiftCardDetail;
use App\Models\ImportOrder\OrderItemAppliedTax;
use App\Models\ImportOrder\OrderLoyaltyCampaign;
use App\Models\ImportOrder\OrderItemAppliedTaxDetail;

class ImportController extends Controller
{
    protected $modelName = 'Import Order';
    protected $routeName = 'role.index';
    protected $isDestroyingAllowed;
    protected $model;

    public function __construct(ImportOrder $model)
    {
        $this->model = $model;
        $this->isDestroyingAllowed = true;
    }

    public function index()
    {
        try {
            // $this->clearImportOrderTables();
            // return;
            $response = Http::custom()
                ->withHeaders([
                    'X-DES-EXT-SERVICE-AK' => '101b62e158cf4b81bfd6c49e14332380'
                ])->get('https://api.qa-jtides.com/MMDESUAE/EES-IN/OMS/V1/orders');

            if ($response->successful()) {
                $objectData = $response->json('items');

                $orders = json_decode(json_encode($objectData));

                return DB::transaction(function () use ($orders) {
                    foreach ($orders as $order) {
                        $this->processOrder($order);
                    }
                });
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Unable to fetch orders'], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Order Import Error: ' . $e->getMessage());
            throw $e;
            // return response()->json(['error' =>  $e->getMessage()], 500);
        }
    }

    protected function processOrder($order)
    {
        $orderId = $order->info->order_id;

        // Ensure all operations for a single order are wrapped in a transaction
        DB::transaction(function () use ($order, $orderId) {
            $this->model->firstOrCreate(['order_id' => $orderId], (array) $order->info);

            OrderLoyaltyCampaign::firstOrCreate(['import_order_id' => $orderId], (array) $order->info->loyalty_campaign);
            OrderCustomer::firstOrCreate(['import_order_id' => $orderId], (array) $order->customer);
            OrderBillingAddress::firstOrCreate(['import_order_id' => $orderId], (array) $order->billing_address);
            OrderPayment::firstOrCreate(['import_order_id' => $orderId], (array) $order->payment);
            OrderShipping::firstOrCreate(['import_order_id' => $orderId], (array) $order->shipping);

            if (count($order->info->coupons) > 0) {
                OrderCoupon::firstOrCreate(['import_order_id' => $orderId], (array) $order->info->coupons);
            }

            $createdGift = OrderGiftCard::firstOrCreate(['import_order_id' => $orderId], (array) $order->gift_card);

            foreach ($order->gift_card->gift_cards as $giftCardDetail) {
                OrderGiftCardDetail::firstOrCreate([
                    'order_gift_card_id' => $createdGift->id,
                    'code' => $giftCardDetail->code ?? '',
                ], [
                    'import_order_id' => $orderId,
                    'amount' => $giftCardDetail->amount ?? '',
                    'base_amount' => $giftCardDetail->base_amount ?? ''
                ]);
            }

            $createdTaxes = OrderTax::firstOrCreate(['import_order_id' => $orderId], (array) $order->taxes);

            //added applied taxes data
            foreach ($order->taxes->applied_taxes as $appliedTax) {
                OrderAppliedTax::firstOrCreate([
                    'appliedTax' => $createdTaxes->id,
                ], [
                    'order_tax_id' => $createdTaxes->id,
                    'amount' => $appliedTax->amount ?? '',
                    'base_amount' => $appliedTax->base_amount ?? ''
                ]);
            }

            //added applied item applied taxes data
            foreach ($order->taxes->item_applied_taxes as $appliedItemTax) {
                $createdItemAppliedTax =  OrderItemAppliedTax::firstOrCreate([
                    'appliedTax' => $appliedItemTax->id,
                ], [
                    'type' => $appliedItemTax->type,
                    'order_tax_id' => $createdTaxes,
                    'item_id' => $appliedItemTax->item_id ?? '',
                    'associated_item_id' => $appliedItemTax->associated_item_id ?? ''
                ]);
            }

            //added applied item applied taxes details data
            if ($order->taxes->item_applied_taxes && $order->taxes->item_applied_taxes->applied_taxes) {
                foreach ($order->taxes->item_applied_taxes->applied_taxes as $key => $appliedItemTaxDetails) {
                    OrderItemAppliedTaxDetail::firstOrCreate([
                        'appliedTax' => $appliedItemTaxDetails->id,
                    ], [
                        'order_item_applied_tax_id' => $createdItemAppliedTax->id,
                        'base_amount' => $appliedItemTaxDetails->base_amount,
                        'amount' => $appliedItemTaxDetails->amount ?? '',
                    ]);
                }
            }

            foreach ($order->products as $key => $product) {
                $createdOrderProducts = OrderProduct::firstOrCreate(['import_order_id' => $orderId, 'product_id' => $product->product_id], (array)$product);

                //added production items
                if ($order->products && $product->items) {
                    foreach ($product->items as $key => $item) {
                        OrderProductItem::firstOrCreate(
                            [
                                'import_order_id' => $orderId,
                                'order_product_id' => $createdOrderProducts->id,
                                'sku' => $item->sku,
                                'name' => $item->name ?? '',
                                'qty' => $item->qty ?? '',
                            ],
                            [
                                'import_order_id' => $orderId,
                                'order_product_id' => $createdOrderProducts->id,
                                'sku' => $item->sku,
                                'name' => $item->name ?? '',
                                'qty' => $item->qty ?? '',
                                'special_promo_bundle_campaign_1' => $item->special_promo_bundle_campaign_1 ?? '',
                            ]
                        );
                    } //end foreach
                }

                //added production items
                if ($order && $order->adjustments) {
                    foreach ($order->adjustments as $key => $adjustment) {
                        OrderAdjustment::firstOrCreate(
                            [
                                'import_order_id' => $orderId,
                                'type' => $adjustment->type,
                                'status' => $adjustment->status,
                                'inform_warehouse' => $adjustment->inform_warehouse ?? '',
                                'open_date' => $adjustment->open_date ?? '',
                                'tax_amount' => $adjustment->tax_amount ?? '',
                            ],
                            [
                                'import_order_id' => $orderId,
                                'type' => $adjustment->type,
                                'status' => $adjustment->status ?? '',
                                'inform_warehouse' => $adjustment->inform_warehouse ?? '',
                                'open_date' => $adjustment->open_date ?? '',
                                'tax_amount' => $adjustment->tax_amount ?? '',
                            ]
                        );
                    } //end foreach
                }
            }
        });
    }

    public function indexOld()
    {
        try {
            $response = Http::custom()
                ->withHeaders([
                    'X-DES-EXT-SERVICE-AK' => '101b62e158cf4b81bfd6c49e14332380'
                ])->get('https://api.qa-jtides.com/MMDESUAE/EES-IN/OMS/V1/orders');


            // return   OrderBillingAddress::get();

            if ($response->successful()) {

                // Convert response to object
                $array = $response->json();
                $objectData = json_decode(json_encode($array))->items;

                return $objectData;
                // Accessing order_id from the converted object
                // return $object->items[0]->info->order_id;

                foreach ($objectData as $key => $item) {
                    // return $item;
                    $info = (array)$item->info;
                    $coupons = (array)$item->info->coupons;
                    $loyaltyCampaign = (array)$item->info->loyalty_campaign;
                    $customer = (array)$item->customer;
                    $billingAddress = (array)$item->billing_address;
                    $orderPayment = (array)$item->payment;
                    $shipping = (array)$item->shipping;
                    $giftCard = (array)$item->gift_card;
                    $giftCardDetails = (array)$item->gift_card->gift_cards;

                    $orderId = $info['order_id'];
                    $this->model->firstOrCreate(['order_id' => $orderId], $info);
                    OrderCoupon::firstOrCreate(['import_order_id' => $orderId], $coupons);
                    OrderLoyaltyCampaign::firstOrCreate(['import_order_id' => $orderId], $loyaltyCampaign);
                    OrderCustomer::firstOrCreate(['import_order_id' => $orderId], $customer);
                    OrderBillingAddress::firstOrCreate(['import_order_id' => $orderId], $billingAddress);
                    OrderPayment::firstOrCreate(['import_order_id' => $orderId], $orderPayment);
                    OrderShipping::firstOrCreate(['import_order_id' => $orderId], $shipping);
                    $createdGift = OrderGiftCard::firstOrCreate(['import_order_id' => $orderId], $giftCard);
                    foreach ($giftCardDetails as $key => $item) {
                        $detailArr = ['import_order_id' => $orderId, 'order_gift_card_id' => $createdGift->id, 'code' => '', 'amount' => '', 'base_amount' => ''];
                        $createdGift = OrderGiftCardDetail::firstOrCreate(['order_gift_card_id' => $createdGift->id], $detailArr);
                    }
                    // return;
                }

                // ImportOrder::create()


                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Unable to fetch orders'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    private function clearImportOrderTables()
    {

        // List of tables to truncate
        $tables = [
            'import_orders',           // Replace with actual table names
            'order_coupons',
            'order_loyalty_campaigns',
            'order_customers',
            'order_billing_addresses',
            'order_payments',
            'order_shippings',
            'order_gift_cards',
            'order_gift_card_details',
            'order_applied_taxes',
            'order_taxes',
            'order_product_items',
            'order_products',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }
}
