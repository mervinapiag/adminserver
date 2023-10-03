<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Http\Requests\ProductVariantRequest;

class ProductVariantController extends Controller
{
    public function index()
    {
        return response()->json(ProductVariant::all(), 200);
    }

    public function store(ProductVariantRequest $request)
    {
        try {
            $variant = ProductVariant::create($request->validated());
            return response()->json($variant, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product variant', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(ProductVariant $variant)
    {
        return response()->json($variant, 200);
    }

    public function update(ProductVariantRequest $request, ProductVariant $variant)
    {
        try {
            $variant->update($request->validated());
            return response()->json($variant, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product variant', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(ProductVariant $variant)
    {
        try {
            $variant->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product variant', 'message' => $e->getMessage()], 500);
        }
    }
}
