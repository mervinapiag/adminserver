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
    
            // Initialize an array to hold multiple images
            $images = [];
    
            // Check if multiple images are uploaded
            if ($request->hasFile('image_paths')) {
                foreach ($request->file('image_paths') as $file) {
                    $imageName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public', $imageName);
    
                    $imageData = $data;
                    $imageData['image_path'] = $imageName;
    
                    $productImage = ProductImage::create($imageData);
                    $images[] = $productImage;
                }
            }
    
            return response()->json(['images' => $images], 201);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product images', 'message' => $e->getMessage()], 500);
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
                $imageName = time() . '_' . $request->image_path->getClientOriginalName();
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
            // Delete the actual image file from storage
            if ($image->image_path) {
                Storage::delete('public/' . $image->image_path);
            }
    
            // Delete the database record
            $image->delete();
    
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product image', 'message' => $e->getMessage()], 500);
        }
    }

    
}
