<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Http\Requests\AccessoryRequest;
use Illuminate\Support\Facades\Storage;

class AccessoryController extends Controller
{
    public function index()
    {
        return response()->json(Accessory::all(), 200);
    }

    public function store(AccessoryRequest $request)
    {
        try {
            $data = $request->validated();
    
            // Check if an image is uploaded
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->storeAs('public', $imageName);
                $data['image'] = $imageName;
            }
    
            $accessory = Accessory::create($data);
            return response()->json($accessory, 201);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create accessory', 'message' => $e->getMessage()], 500);
        }
    }
    

    public function show(Accessory $accessory)
    {
        return response()->json($accessory, 200);
    }

    public function update(AccessoryRequest $request, Accessory $accessory)
    {
        try {
            $data = $request->validated();
    
            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete old image
                if ($accessory->image) {
                    Storage::delete('public/' . $accessory->image);
                }
    
                // Store new image
                $imageName = time() . '.' . $request->image->extension();
                $request->image->storeAs('public', $imageName);
                $data['image'] = $imageName;
            }
    
            $accessory->update($data);
            return response()->json($accessory, 200);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update accessory', 'message' => $e->getMessage()], 500);
        }
    }
    

    public function destroy(Accessory $accessory)
    {
        try {
            $accessory->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete accessory', 'message' => $e->getMessage()], 500);
        }
    }
}
