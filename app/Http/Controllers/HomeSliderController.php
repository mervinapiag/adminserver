<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSlider;
use DB;

class HomeSliderController extends Controller
{
    public function fetchSlides()
    {
        $currentDate = date('Y-m-d');

        $sliders = DB::table('home_sliders')
            ->whereDate('start_date', '<=', $currentDate)
            ->whereDate('end_date', '>=', $currentDate)
            ->whereNull('deleted_at')
            ->get();

        return $sliders;
    }

    public function index() 
    {
        return HomeSlider::all();
    }

    public function store(Request $request) 
    {
        return HomeSlider::create([
            'image_url' => $request->image_url,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
    }

    public function update(Request $request, $id) 
    {
        try {
            $data = HomeSlider::find($id)->update([
                'image_url' => $request->image_url,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            return response()->json([
                'Home Slider has been updated'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update Home Slider', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id) 
    {
        try {
            $data = HomeSlider::find($id);
            $data->delete();
            
            return response()->json([
                'Home Slider deleted'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete Home Slider', 'message' => $e->getMessage()], 500);
        }
    }
}
