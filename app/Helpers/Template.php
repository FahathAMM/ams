<?php



if (!function_exists('isActive')) {
    function isActive($status, $par)
    {
        if ($par == 'val') {
            return   $status ? 'Active' : 'Inactive';
        } else if ($par == 'col') {
            return  $status ? 'success' : 'danger';
        } else {
            return '';
        }
    }
}

if (!function_exists('duration')) {
    function duration($startDate, $endDate)
    {
        // Define the start and end dates
        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);

        // Calculate the difference
        $interval = $startDate->diff($endDate);

        // Output the duration
        return   $dur = $interval->y . ' years, ' . $interval->m . ' months, ' . $interval->d . ' days.';
    }
}


if (!function_exists('orderBasicInfo')) {
    function orderBasicInfo($order)
    {
        $orderDetailsWithIcons = [
            'fms_number' => [
                'value' => $order->fms_number ?? '---',
                'icon' => 'ri-barcode-line',
            ],
            'subtotal' => [
                'value' => $order->subtotal ?? '',
                'icon' => 'ri-money-dollar-circle-fill',
            ],
            'total_due' => [
                'value' => $order->total_due ?? '',
                'icon' => 'ri-money-dollar-circle-fill',
            ],
            'total_discount' => [
                'value' => $order->total_discount ?? '',
                'icon' => 'ri-price-tag-line',
            ],
            'shipping_amount' => [
                'value' => $order->shipping_amount ?? '',
                'icon' => 'ri-truck-line',
            ],
            'total_item_count' => [
                'value' => $order->total_item_count ?? '',
                'icon' => 'ri-shopping-cart-line',
            ],
            'total' => [
                'value' => $order->total ?? '',
                'icon' => 'ri-money-dollar-circle-fill',
            ],
            'discount' => [
                'value' => $order->discount ?? '',
                'icon' => 'ri-price-tag-line',
            ],
            'tax_total' => [
                'value' => $order->tax_total ?? '',
                'icon' => 'ri-file-tax-line',
            ],
            'shipping_amount_tax' => [
                'value' => $order->shipping_amount_tax ?? '',
                'icon' => 'ri-file-tax-line',
            ],
            'cancel_reason_code' => [
                'value' => $order->cancel_reason_code ?? '---',
                'icon' => 'ri-error-warning-line',
            ],
            'cancel_reason_message' => [
                'value' => $order->cancel_reason_message ?? '---',
                'icon' => 'ri-error-warning-line',
            ],
        ];

        return $orderDetailsWithIcons;
    }
}


if (!function_exists('orderBillingInfo')) {
    function orderBillingInfo($order)
    {
        $billingAddress = $order->billingAddress;

        $billingAddressArr = [
            'firstname' => $billingAddress->firstname ?? '---',
            'lastname' => $billingAddress->lastname ?? '---',
            'email' => $billingAddress->email ?? '---',
            'telephone' => $billingAddress->telephone ?? '---',
            'country_id' => $billingAddress->country_id ?? '---',
            'city' => $billingAddress->city ?? '---',
            'postcode' => $billingAddress->postcode ?? '---',
            'street' => implode(', ', $billingAddress->street) ?? '---',
            'address_type' => $billingAddress->address_type ?? '---',
            'company' => $billingAddress->company ?? '---',
            'store_name' => $billingAddress->store_name ?? '---',
            'administrative_area_level_2' => $billingAddress->administrative_area_level_2 ?? '---',
            'sublocality_level_2' => $billingAddress->sublocality_level_2 ?? '---',
        ];

        return $billingAddressArr;
    }
}
if (!function_exists('orderShippingInfo')) {
    function orderShippingInfo($order)
    {
        $shippingAddress = $order->shipping;
        $shippingAddressObj = (object)$order->shipping->address;


        $shippingAddressArr = [
            'firstname' => $shippingAddressObj->firstname ?? '---',
            'lastname' => $shippingAddressObj->lastname ?? '---',
            'email' => $shippingAddressObj->email ?? '---',
            'telephone' => $shippingAddressObj->telephone ?? '---',
            'country_id' => $shippingAddressObj->country_id ?? '---',
            'city' => $shippingAddressObj->city ?? '---',
            'postcode' => $shippingAddressObj->postcode ?? '---',
            'street' =>  implode(', ', $shippingAddressObj->street) ?? '---',
            'method' => $shippingAddress->method ?? '---',
            'amount' => $shippingAddress->amount ?? '---',
            'address_type' => $shippingAddressObj->address_type ?? '---',
            'company' => $shippingAddressObj->company ?? '---',
            'store_name' => $shippingAddressObj->store_name ?? '---',
            'administrative_area_level_2' => $shippingAddressObj->administrative_area_level_2 ?? '---',
            'sublocality_level_2' => $shippingAddressObj->sublocality_level_2 ?? '---',
        ];


        return $shippingAddressArr;
    }
}

if (!function_exists('getGreeting')) {
    function getGreeting()
    {
        $hour = date('H');

        if ($hour < 12) {
            return 'Good Morning';
        } elseif ($hour < 18) {
            return 'Good Afternoon';
        } else {
            return 'Good Evening';
        }
    }
}


if (!function_exists('logAction')) {
    function logAction($value)
    {
        $arr = [
            'Create' => 'bg-success',
            'Update' => 'bg-primary',
            'Delete' => 'bg-danger',
        ];

        return " <span class='badge  " . $arr[$value] . "'> $value </span> ";
        return "<h5 class='fs-14 my-1 fw-normal'> <span class='badge  " . $arr[$value] . "'> $value </span> </h5>";
    }
}


if (!function_exists('eodStatus')) {
    function eodStatus($value)
    {
        $arr = [
            'completed' => 'bg-success',
            'pending' => 'bg-danger',
            'wip' => 'bg-warning',
        ];

        return " <span class='badge  " . $arr[$value] . "'> $value </span> ";
        return "<h5 class='fs-14 my-1 fw-normal'> <span class='badge  " . $arr[$value] . "'> $value </span> </h5>";
    }
}

if (!function_exists('getInitials')) {
    function getInitials($string)
    {
        $words = explode(' ', $string);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper($word[0]);
        }

        return $initials;
    }
}

if (!function_exists('getDeviceIcon')) {
    function getDeviceIcon($device)
    {
        $icons = [
            'Mobile' => 'ri-smartphone-line',
            'Tablet' => 'ri-tablet-line',
            'Desktop' => 'ri-computer-line',
        ];

        return $icons[$device] ?? 'ri-question-line';
    }
}
