<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FAQAnswer;

class FAQAnswerController extends Controller
{
    public function index() 
    {
        return FAQAnswer::all();
    }

    public function store(Request $request) 
    {
        return FAQAnswer::create([
            'faq_id' => $request->faq_id,
            'answer_text' => $request->answer_text,
        ]);
    }

    public function update(Request $request, $id) 
    {
        try {
            $data = FAQAnswer::find($id)->update([
                'answer_text' => $request->answer_text,
            ]);

            return response()->json([
                'FAQ answer has been updated'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update FAQ answer', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id) 
    {
        try {
            $data = FAQAnswer::find($id);
            $data->delete();
            
            return response()->json([
                'FAQ answer deleted'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete FAQ answer', 'message' => $e->getMessage()], 500);
        }
    }
}
