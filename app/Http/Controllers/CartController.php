<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function __construct(Cart $cart_model, CartRepository $cart_repository)
    {
        $this->cart_model = $cart_model;
        $this->cart_repository = $cart_repository;
    }

    public function index(Request $request)
    {
        return $this->cart_repository->getAll();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_unit_id' => 'required',
            'quantity' => 'required',
        ]);

        $input = $request->all();
        $input['user_id'] = auth()->check() ? auth()->user()->id : 0;
        $input['session_id'] = auth()->check() ? 0 : session()->getId();
        $cart = $this->cart_model->updateOrCreate([
            'user_id' => $input['user_id'],
            'session_id' => $input['session_id'],
            'product_id' => $input['product_id'],
            'name' => $input['name'],
            'product_unit_id' => $input['product_unit_id'],
            'price' => $input['price'],
        ], [
            'quantity' => \DB::raw('quantity + ' . $input['quantity']),
        ]);

        return response()->json($cart);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_unit_id' => 'required',
            'quantity' => 'required',
        ]);

        $cart = $this->cart_model->findOrFail($id);
        $input = $request->all();
        $cart->fill($input)->save();

        return response()->json($cart);
    }

    public function destroy($id)
    {
        if (auth()->check()) {
            if (!auth()->user()->hasAnyRole('Customer')) {
                abort('401', '401');
            }
        }

        $cart = $this->cart_model->findOrFail($id);
        $cart->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Cart successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return response()->json($response);
    }
}
