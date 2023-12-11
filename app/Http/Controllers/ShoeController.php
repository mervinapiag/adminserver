<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use App\Models\Product;
use App\Http\Requests\ShoeRequest;
use App\Models\Accessory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductType;

class ShoeController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('Type');
        $brand = $request->input('Brand');
        $gender = $request->input('Gender');
        $socks = $request->input('Socks');
        $sizes = $request->input('Sizes');

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
        $sizes = $request->input('Sizes');

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

    public function store(Request $request)
    {

        try {
            $data = $request->all();
            DB::beginTransaction();
            // Check if an image is uploaded
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->image->getClientOriginalName();
                $request->image->storeAs('public', $imageName);
                $data['image'] = $imageName;
            }

            $shoe = Product::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'gender' => $data['gender'],
                'socks' => $data['socks'],
                'product_category_id' => $data['product_category_id'],
                'brand_id' => $data['brand_id'],
                'status' => $data['status'],
                'image' => $data['image'],
            ]);
            
            foreach ($data['types'] as $t) {
                $type = ProductType::whereName($t)->first();
                DB::table('product_has_types')->insert([
                    'product_id' => $shoe->id,
                    'product_type_id' => $type->id,
                ]);
            }
            
            foreach ($data['sizes'] as $s) {
                $size = ProductSize::whereName($s)->first();
                DB::table('product_has_sizes')->insert([
                    'product_id' => $shoe->id,
                    'product_size_id' => $size->id,
                ]);
            }

            foreach ($data['colors'] as $c) {
                $color = ProductColor::whereName($c)->first();
                DB::table('product_has_colors')->insert([
                    'product_id' => $shoe->id,
                    'product_color_id' => $color->id,
                ]);
            }

            if ($request->hasFile('images')) {
                foreach ($data['images'] as $image) {
                    $file_name = time().rand(1,99).'.'.$file->extension();
                    $file->move(public_path('uploads'), $file_name);
                    
                    DB::table('product_has_images')->insert([
                        'product_id' => $shoe->id,
                        'imae_url' => $file_name,
                    ]);
                }
            }


            DB::commit();
            // Check if there are recommended accessories tied with the shoes (colored lace or socks)
            // DB::beginTransaction();
            // if ($request->has('recommended_accessories')) {
            //     foreach ($request->recommended_accessories as $index => $value) {
            //         $accessory = Accessory::find($value);
            //         $shoe->recommended_accessories()->save($accessory);
            //     }
            // }
            // DB::commit();
            return response()->json($shoe, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create product', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Product $shoe)
    {
        //return response()->json($shoe->load(['variants', 'images', 'recommended_accessories']), 200);
        return response()->json($shoe, 200);
    }



    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $shoe = Product::find($id);
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

            $shoe->update(
                ['name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'gender' => $data['gender'],
                'socks' => $data['socks'],
                'product_category_id' => $data['product_category_id'],
                'brand_id' => $data['brand_id'],
                'status' => $data['status'],
                'image' => $data['image'],
            ]);
            
            $shoe->types()->delete();
            $shoe->sizes()->delete();
            $shoe->colors()->delete();

            foreach ($data['types'] as $type) {
                DB::table('product_has_types')->insert([
                    'product_id' => $shoe->id,
                    'product_type_id' => $type->id,
                ]);
            }

            foreach ($data['sizes'] as $size) {
                DB::table('product_has_sizes')->insert([
                    'product_id' => $shoe->id,
                    'product_size_id' => $size->id,
                ]);
            }

            foreach ($data['colors'] as $color) {
                DB::table('product_has_sizes')->insert([
                    'product_id' => $shoe->id,
                    'product_color_id' => $color->id,
                ]);
            }

            return response()->json($shoe, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $shoe = Product::find($id);

            $shoe->types()->delete();
            $shoe->sizes()->delete();
            $shoe->colors()->delete();

            $shoe->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product', 'message' => $e->getMessage()], 500);
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

    public function getTypes()
    {
        $data = ProductType::whereNull('deleted_at')->get();

        return response()->json($data);
    }

    public function typesStore(Request $request)
    {
        $input = $request->all();
        $data = ProductType::create($input);

        return response()->json($data, 201);
    }

    public function typesUpdate(Request $request, $id)
    {
        $input = $request->all();
        $data = ProductType::find($id)->update($input);

        return response()->json($data, 201);
    }

    public function typesDelete(Request $request, $id)
    {
        $data = ProductType::find($id)->delete();

        return response()->json(null, 204);
    }

    public function getCategories()
    {
        $data = ProductCategory::whereNull('deleted_at')->get();

        return response()->json($data);
    }

    public function categoriesStore(Request $request)
    {
        $input = $request->all();
        $data = ProductCategory::create($input);

        return response()->json($data, 201);
    }

    public function categoriesUpdate(Request $request, $id)
    {
        $input = $request->all();
        $data = ProductCategory::find($id)->update($input);

        return response()->json($data, 201);
    }

    public function categoriesDelete(Request $request, $id)
    {
        $data = ProductCategory::find($id)->delete();

        return response()->json(null, 204);
    }

    public function getBrands()
    {
        $data = ProductBrand::whereNull('deleted_at')->get();

        return response()->json($data);
    }

    public function brandsStore(Request $request)
    {
        $input = $request->all();
        $data = ProductBrand::create($input);

        return response()->json($data, 201);
    }

    public function brandsUpdate(Request $request, $id)
    {
        $input = $request->all();
        $data = ProductBrand::find($id)->update($input);

        return response()->json($data, 201);
    }

    public function brandsDelete(Request $request, $id)
    {
        $data = ProductBrand::find($id)->delete();

        return response()->json(null, 204);
    }

    public function getSizes()
    {
        $data = ProductSize::whereNull('deleted_at')->get();

        return response()->json($data);
    }

    public function sizesStore(Request $request)
    {
        $input = $request->all();
        $data = ProductSize::create($input);

        return response()->json($data, 201);
    }

    public function sizesUpdate(Request $request, $id)
    {
        $input = $request->all();
        $data = ProductSize::find($id)->update($input);

        return response()->json($data, 201);
    }

    public function sizesDelete(Request $request, $id)
    {
        $data = ProductSize::find($id)->delete();

        return response()->json(null, 204);
    }

    public function getColors()
    {
        $data = ProductColor::whereNull('deleted_at')->get();

        return response()->json($data);
    }

    public function colorsStore(Request $request)
    {
        $input = $request->all();
        $data = ProductColor::create($input);

        return response()->json($data, 201);
    }

    public function colorsUpdate(Request $request, $id)
    {
        $input = $request->all();
        $data = ProductColor::find($id)->update($input);

        return response()->json($data, 201);
    }

    public function colorsDelete(Request $request, $id)
    {
        $data = ProductColor::find($id)->delete();

        return response()->json(null, 204);
    }
}
