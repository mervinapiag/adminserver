<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscountCoupon;

class DiscountController extends Controller
{
    public function index() 
    {
        return DiscountCoupon::all();
    }

    public function store(Request $request) 
    {
        return DiscountCoupon::create([
            'name' => $request->name,
            'discount_code' => $request->discount_code,
            'total_amount' => $request->total_amount,
            'date_limit' => $request->date_limit,
            'is_active' => $request->is_active
        ]);
    }

    public function update(Request $request, $id) 
    {
        try {
            $data = DiscountCoupon::find($id)->update([
                'name' => $request->name,
                'discount_code' => $request->discount_code,
                'total_amount' => $request->total_amount,
                'date_limit' => $request->date_limit,
                'is_active' => $request->is_active
            ]);

            return response()->json([
                'Discount coupon has been updated'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update Discount Code', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id) 
    {
        try {
            $data = DiscountCoupon::find($id);
            $data->delete();
            
            return response()->json([
                'Discount coupon deleted'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete Discount Code', 'message' => $e->getMessage()], 500);
        }
    }
}
