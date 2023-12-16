<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FAQ;
use App\Models\FAQAnswer;

class FAQController extends Controller
{
    public function index() 
    {
        return FAQ::all();
    }

    public function store(Request $request) 
    {
        return FAQ::create([
            'question_text' => $request->question_text,
        ]);
    }

    public function update(Request $request, $id) 
    {
        try {
            $data = FAQ::find($id)->update([
                'question_text' => $request->question_text,
            ]);

            return response()->json([
                'FAQ has been updated'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update FAQ', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id) 
    {
        try {
            $data = FAQ::find($id);
            $data->delete();

            $data2 = FAQAnswer::where('faq_id', $id)->get();
            foreach ($data2 as $d) {
                $d->delete();
            }
            
            return response()->json([
                'FAQ deleted'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete FAQ', 'message' => $e->getMessage()], 500);
        }
    }
}
