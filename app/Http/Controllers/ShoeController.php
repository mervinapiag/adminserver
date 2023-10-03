<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use App\Http\Requests\ShoeRequest;
use Illuminate\Support\Facades\Storage;

class ShoeController extends Controller
{
    public function index()
    {
        return response()->json(Shoe::all(), 200);
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
}
