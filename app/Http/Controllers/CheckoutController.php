<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Checkout;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {
        $cartsData = $request->cartsData;
        $checkoutData = $request->checkoutData;

        $order = $this->createOrder($checkoutData);
        $items = $this->createCartItems($order, $cartsData);

        return $order;
    }

    public function createOrder($cartsData = [])
    {
        return Checkout::create([
            'reference_number' => $this->createOrderReferenceNumber(),
            'user_id' => $cartsData['user_id'],
            'region' => $cartsData['region'],
            'first_name' => $cartsData['first_name'],
            'last_name' => $cartsData['last_name'],
            'barangay' => $cartsData['barangay'],
            'street_bldg_name' => $cartsData['street_bldg_name'],
            'postal_code' => $cartsData['postal_code'],
            'city' => $cartsData['city'],
            'email' => $cartsData['email'],
            'phone_number' => $cartsData['phone_number'],
            'courier' => $cartsData['courier'],
            'payment_method' => $cartsData['payment_method'],
            'receipt_img' => $cartsData['receipt_img'],
            'grand_total' => $cartsData['grand_total'],
        ]);
    }

    public function createCartItems($order, $carts = [])
    {
        $items = [];
        foreach ($carts as $cart) {
            $items[] = $order->items()->create([
                'product_id' => $cart['product_id'],
                'size' => $cart['size'],
                'session_id' => $cart['session_id'],
                'user_id' => $cart['user_id'],
                'quantity' => $cart['quantity'],
                'price' => $cart['price'],
                'total' => $cart['total'],
            ]);
        }

        return $items;
    }

    public function createOrderReferenceNumber($code = 'OR')
    {
        $max_code = $code . '00001';
        $max_id = Checkout::max('id');
        if ($max_id) {
            $max_code = substr($max_code, 0, -strlen($max_id)) . '' . ($max_id + 1);
        }
        return $max_code;
    }

    public function salesOrder()
    {
        $salesData = Checkout::all();

        $groupedData = [];
        foreach ($salesData as $sale) {
            $date = date('F j, Y', strtotime($sale['created_at']));
            $groupedData[$date][] = $sale['grand_total'];
        }

        $chartLabels = array_keys($groupedData);
        $chartData = array_map(function ($totals) {
            return number_format(array_sum($totals), 2);
        }, $groupedData);

        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $chartLabels,
                'datasets' => [
                    [
                        'label' => 'Sales',
                        'data' => array_values($chartData),
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'borderColor' => 'rgba(255, 99, 132, 1)',
                        'borderWidth' => 1,
                    ],
                ],
            ],
            'options' => [
                'responsive' => true,
                'title' => [
                    'display' => true,
                    'text' => 'Sales Statistics',
                ],
            ],
        ];

        return $chartConfig;
    }
}
