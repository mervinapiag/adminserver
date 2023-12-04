<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class OTPController extends Controller
{
    public function verify(Request $request)
    {
        $email = $request->email;
        $otp = $request->otp;

        $user = User::where('email', $email)->where('otp', $otp)->first();
        if ($user) {
            if ($user->otp == 'verified') {
                return response()->json([
                    'Account already verified.'
                ], 200);    
            }

            $user->otp = 'verified';
            $user->save();

            return response()->json([
                'Account verified, you may now login to your account'
            ], 200);
        } else {
            return response()->json([
                'Invalid email or OTP code.'
            ], 500);
        }
    }
}
