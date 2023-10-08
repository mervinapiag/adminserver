<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use App\Http\Requests\ShoeRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class ShoeController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sortField', 'name');  // Default sort field is 'name'
        $sortOrder = $request->get('sortOrder', 'asc');  // Default sort order is 'asc'
        
        // Eager load variants and sort
        $shoes = Shoe::with('variants')->orderBy($sortField, $sortOrder)->get();
        
        return response()->json($shoes);
    }
    

    public function store(ShoeRequest $request)
    {
        try {
            $data = $request->validated();
    
            // Check if an image is uploaded
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->storeAs('public', $imageName);
                $data['image'] = $imageName;
            }
    
            $shoe = Shoe::create($data);
            return response()->json($shoe, 201);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create shoe', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Shoe $shoe)
    {
        return response()->json($shoe, 200);
    }

    public function update(ShoeRequest $request, Shoe $shoe)
    {
        try {
            $data = $request->validated();
    
            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete old image
                if ($shoe->image) {
                    Storage::delete('public/' . $shoe->image);
                }
    
                // Store new image
                $imageName = time() . '.' . $request->image->extension();
                $request->image->storeAs('public', $imageName);
                $data['image'] = $imageName;
            }
    
            $shoe->update($data);
            return response()->json($shoe, 200);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update shoe', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Shoe $shoe)
    {
        try {
            $shoe->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete shoe', 'message' => $e->getMessage()], 500);
        }
    }

        public function getVariants($id)
    {
        $shoe = Shoe::find($id);
        if ($shoe) {
            return response()->json($shoe->variants);
        } else {
            return response()->json(['message' => 'Shoe not found'], 404);
        }
    }

    public function getImageVariants($id) {
        $shoe = Shoe::findOrFail($id);
        $images = $shoe->images;  // Assuming you have an 'images' relationship
        return response()->json($images);
    }

    public function getImages(Shoe $shoe) {
    return response()->json($shoe->images);
}

}
