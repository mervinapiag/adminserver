<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Http\Requests\ProductImageRequest;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function index()
    {
        return response()->json(ProductImage::all(), 200);
    }

    public function store(ProductImageRequest $request)
    {
        try {
            $data = $request->validated();
    
            // Check if an image is uploaded
            if ($request->hasFile('image_path')) {
                $imageName = time() . '.' . $request->image_path->extension();
                $request->image_path->storeAs('public', $imageName);
                $data['image_path'] = $imageName;
            }
    
            $productImage = ProductImage::create($data);
            return response()->json($productImage, 201);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product image', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(ProductImage $image)
    {
        return response()->json($image, 200);
    }

    public function update(ProductImageRequest $request, ProductImage $productImage)
    {
        try {
            $data = $request->validated();
    
            // Check if a new image is uploaded
            if ($request->hasFile('image_path')) {
                // Delete old image
                if ($productImage->image_path) {
                    Storage::delete('public/' . $productImage->image_path);
                }
    
                // Store new image
                $imageName = time() . '.' . $request->image_path->extension();
                $request->image_path->storeAs('public', $imageName);
                $data['image_path'] = $imageName;
            }
    
            $productImage->update($data);
            return response()->json($productImage, 200);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product image', 'message' => $e->getMessage()], 500);
        }
    }
    

    public function destroy(ProductImage $image)
    {
        try {
            $image->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product image', 'message' => $e->getMessage()], 500);
        }
    }
}
