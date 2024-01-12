<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class RoleController extends Controller
{
    //
    public function index(Request $request) 
    {
        return Role::all();
    }

    public function store(Request $request) 
    {
        try {
            return Role::create([
                'name' => $request->name,
                'role' => $request->role,
                'permissions' => $request->permissions
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create role', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, $id) 
    {
        try {
            return Role::find($id);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to find role', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) 
    {
        try {
            return Role::find($id)->update([
                'name' => $request->name,
                'role' => $request->role,
                'permissions' => $request->permissions
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update role', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id) 
    {
        try {
            $role = Role::find($id);
            $role->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete role', 'message' => $e->getMessage()], 500);
        }
    }

    public function me($id)
    {
        return User::find($id);
    }
}
