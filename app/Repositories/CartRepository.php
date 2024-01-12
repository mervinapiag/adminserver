<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CouponCode;
use File;

/**
 * Class CartRepository
 * @package App\Repositories
 * @author 
 */
class CartRepository
{
    /**
     * Get all instance
     *
     * @return App/Models/Cart;
     */
    public function getAll()
    {
        $items = [];
        if (auth()->check()) {
            $items = Cart::where('user_id', auth()->user()->id)->get();
        } else {
            $items = Cart::where('session_id', session()->getId())->get();
        }

        foreach ($items as $item) {
            $item = $this->getData($item);
        }
        return $items;
    }

    public function getCartTotals()
    {
        $items = [];
        if (auth()->check()) {
            if (auth()->user()->hasAnyRole('Customer')) {
                $items = Cart::where('user_id', auth()->user()->id)->get();
            }
        } else {
            $items = Cart::where('session_id', session()->getId())->get();
        }

        $totals = [
            'subtotal' => 0,
            'shipping' => 0,
            'tax' => 0,
            'discount' => 0,
            'total' => 0,
        ];
        $subtotal = 0;
        $shipping = 0;
        $tax = 0;
        $discount = 0;

        /* compute subtotal */
        foreach ($items as $item) {
            $subtotal += $item->total;
        }

        /* compute tax */
        $tax = $tax;

        /* compute shipping */
        $shipping = $shipping;

        /* compute total */
        $total = ($subtotal + $shipping + $tax) - $discount;

        $totals['subtotal'] = $subtotal;
        $totals['shipping'] = $shipping;
        $totals['tax'] = $tax;
        $totals['discount'] = $discount;
        $totals['discount_code_text'] = isset($coupon_code) ? $coupon_code->code . ($coupon_code->type == 1 ? ' (-' . $coupon_code->value . '%)' : ' (-$' . $coupon_code->value . ')') : NULL;
        $totals['coupon_id'] = ($coupon_code) ? $coupon_code->id : 0;
        $totals['coupon_code'] = isset($coupon_code) ? $coupon_code->code : NULL;
        $totals['total'] = $total;
        return $totals;
    }

    /**
     * Get data
     *
     * @param  $item
     *
     * @return \App\Models\Contact;
     */
    public function getData($item)
    {
        if (!empty($item)) {

        }

        return $item;
    }
}