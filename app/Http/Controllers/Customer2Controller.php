<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class Customer2Controller extends Controller
{
    // Customers

    public function index()
    {
        return User::where('role_id', 1)->get();
    }
    
    public function store(Request $request)
    {
        return User::create([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "name" => $request->firstname . " " . $request->lastname,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role_id" => 1,
            "otp" => "verified"
        ]);
    }
    
    public function update(Request $request, $id)
    {
        User::find($id)->update([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "name" => $request->firstname . " " . $request->lastname,
            "email" => $request->email,
            "password" => $request->password,
            "role_id" => 1
        ]);

        return response()->json(['message' => 'Customer updated'], 200);
    }
    
    public function destroy($id)
    {
        User::find($id)->delete();
        
        return response()->json(['message' => 'Customer deleted'], 200);
    }

    public function suspend($id)
    {
        $user = User::find($id);
        if ($user->suspended == 1) {
            $user->suspended = 0;
        } else {
            $user->suspended = 1;
            $user->tokens()->delete();
        }
        $user->save();
        
        return response()->json(['message' => 'Customer ' . ($user->suspended == 1) ? 'suspended' : 'unsuspended'], 200);
    }

    // Admins
    
    public function indexAdmin()
    {
        return User::where('role_id', 2)->get();
    }
    
    public function storeAdmin(Request $request)
    {
        return User::create([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "name" => $request->firstname . " " . $request->lastname,
            "email" => $request->email,
            "password" => $request->password,
            "role_id" => $request->role_id,
            "otp" => "verified"
        ]);
    }
    
    public function updateAdmin(Request $request, $id)
    {
        User::find($id)->update([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "name" => $request->firstname . " " . $request->lastname,
            "email" => $request->email,
            "password" => $request->password,
            "role_id" => $request->role_id
        ]);

        return response()->json(['message' => 'Admin updated'], 200);
    }
    
    public function destroyAdmin($id)
    {
        User::find($id)->delete();

        return response()->json(['message' => 'Admin deleted'], 200);
    }

    public function suspendAdmin($id)
    {
        $user = User::find($id);
        $user->suspended = 1;
        $user->save();

        $user->tokens()->delete();
        
        return response()->json(['message' => 'Admin suspended'], 200);
    }
}
