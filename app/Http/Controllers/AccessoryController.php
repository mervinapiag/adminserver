<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Http\Requests\AccessoryRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AccessoryController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sortField', 'name');  // Default sort field is 'name'
        $sortOrder = $request->get('sortOrder', 'asc');  // Default sort order is 'asc'
        
        // Apply sorting
        $accessories = Accessory::orderBy($sortField, $sortOrder)->get();
    
        return response()->json($accessories, 200);
    }
    
    

    public function store(AccessoryRequest $request)
    {
        try {
            $data = $request->validated();
    
            // Check if an image is uploaded
            if ($request->hasFile('image')) {
                // Store new image with a more unique name
                $imageName = time() . '_' . $request->image->getClientOriginalName();
                $request->image->storeAs('public', $imageName);
                $data['image'] = $imageName;
            }
    
            $accessory = Accessory::create($data);
            return response()->json(['data' => $accessory], 201);
    
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
    
                // Store new image with a more unique name
                $imageName = time() . '_' . $request->image->getClientOriginalName();
                $request->image->storeAs('public', $imageName);
                $data['image'] = $imageName;
            }
    
            $accessory->update($data);
            return response()->json(['data' => $accessory], 200);
    
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
    public function getImages(Accessory $accessory) {
    return response()->json($accessory->images);
}

}
