<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;

class GeneralSettings extends Controller
{
    //

    public function generalSettings()
    {
        return GeneralSetting::find(1);
    }

    public function updateWebConfig(Request $request)
    {
        $data = GeneralSetting::find(1);
        $data->logo = $request->logo;
        $data->favicon = $request->favicon;
        $data->header_title = $request->header_title;
        $data->footer_text = $request->footer_text;
        $data->contact_info = $request->contact_info;
        $data->social_media = $request->social_media;
        $data->shipping_rate = $request->shipping_rate;
        $data->save();

        return response()->json([
            'Website Configuration details has been updated'
        ], 200);
    }

    public function updateBasicInfo(Request $request)
    {
        $data = GeneralSetting::find(1);
        $data->about_us_image = $request->about_us_image;
        $data->history_image = $request->history_image;
        $data->about_us_text = $request->about_us_text;
        $data->history_text = $request->history_text;
        $data->privacy_policy = $request->privacy_policy;
        $data->terms_and_condition = $request->terms_and_condition;
        $data->save();

        return response()->json([
            'Basic information details has been updated'
        ], 200);
    }
}
