<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use App\Models\Product;
use App\Http\Requests\ShoeRequest;
use App\Models\Accessory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoeController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('Type');
        $brand = $request->input('Brand');
        $gender = $request->input('Gender');
        $socks = $request->input('Socks');
        $sizes = $request->input('sizes');

        $shoes = Product::whereNull('products.deleted_at');

        if ($type) {
            $typeArray = explode('-', $type);
            if (!empty($typeArray)) {
                $shoes->whereHas('types.type', function ($query) use ($typeArray) {
                    $query->whereIn('name', $typeArray);
                });
            }
        }

        if ($brand) {
            $brandArray = explode('-', $brand);
            if (!empty($brandArray)) {
                $shoes->whereHas('brand', function ($query) use ($brandArray) {
                    $query->whereIn('product_brands.name', $brandArray);
                });
            }
        }
        
        if ($gender) {
            $genderArray = explode('-', $gender);
            if (!empty($genderArray)) {
                $shoes->whereIn('products.gender', $genderArray);
            }
        }
        
        if ($socks) {
            $socksArray = explode('-', $socks);
            if (!empty($socksArray)) {
                $shoes->whereIn('products.socks', $socksArray);
            }
        }
        
        if ($sizes) {
            $sizesArray = explode('-', $sizes);
            if (!empty($sizesArray)) {
                $shoes->whereHas('sizes.size', function ($query) use ($sizesArray) {
                    $query->whereIn('name', $sizesArray);
                });
            }
        }    

        $shoes = $shoes->get();

        return response()->json($shoes);
    }


    public function mixAndMatch(Request $request)
    {
        $type = $request->input('Type');
        $brand = $request->input('Brand');
        $gender = $request->input('Gender');
        $socks = $request->input('Socks');
        $sizes = $request->input('sizes');

        $shoes = Product::whereNull('products.deleted_at');

        if ($type) {
            $typeArray = explode('-', $type);
            if (!empty($typeArray)) {
                $shoes->whereHas('types.type', function ($query) use ($typeArray) {
                    $query->whereIn('name', $typeArray);
                });
            }
        }

        if ($brand) {
            $brandArray = explode('-', $brand);
            if (!empty($brandArray)) {
                $shoes->whereHas('brand', function ($query) use ($brandArray) {
                    $query->whereIn('product_brands.name', $brandArray);
                });
            }
        }
        
        if ($gender) {
            $genderArray = explode('-', $gender);
            if (!empty($genderArray)) {
                $shoes->whereIn('products.gender', $genderArray);
            }
        }
        
        if ($socks) {
            $socksArray = explode('-', $socks);
            if (!empty($socksArray)) {
                $shoes->whereIn('products.socks', $socksArray);
            }
        }
        
        if ($sizes) {
            $sizesArray = explode('-', $sizes);
            if (!empty($sizesArray)) {
                $shoes->whereHas('sizes.size', function ($query) use ($sizesArray) {
                    $query->whereIn('name', $sizesArray);
                });
            }
        }  

        $shoes = $shoes->get();

        $output = [
            'shoes' => $shoes->filter(function ($product) {
                return $product->product_category_id == 1;
            })->values(), // shoes

            'socks' => $shoes->filter(function ($product) {
                return $product->product_category_id == 2;
            })->values(), // socks

            'accessories' => $shoes->filter(function ($product) {
                return $product->product_category_id == 3;
            })->values(), // accessories
        ];
    
        return response()->json($output);
    }

    public function store(ShoeRequest $request)
    {

        try {
            $data = $request->validated();
            DB::beginTransaction();
            // Check if an image is uploaded
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->image->getClientOriginalName();
                $request->image->storeAs('public', $imageName);
                $data['image'] = $imageName;
            }

            $shoe = Shoe::create($data);

            DB::commit();
            // Check if there are recommended accessories tied with the shoes (colored lace or socks)
            DB::beginTransaction();
            if ($request->has('recommended_accessories')) {
                foreach ($request->recommended_accessories as $index => $value) {
                    $accessory = Accessory::find($value);
                    $shoe->recommended_accessories()->save($accessory);
                }
            }
            DB::commit();
            return response()->json($shoe, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create shoe', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Product $shoe)
    {
        //return response()->json($shoe->load(['variants', 'images', 'recommended_accessories']), 200);
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

                // Store new image with a more unique name
                $imageName = time() . '_' . $request->image->getClientOriginalName();
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

    public function getImageVariants($id)
    {
        $shoe = Shoe::findOrFail($id);
        $images = $shoe->images;  // Assuming you have an 'images' relationship
        return response()->json($images);
    }

    public function getImages(Shoe $shoe)
    {
        return response()->json($shoe->images);
    }
}
