<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;


class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')
        ->where('id', '!=', auth()->id())
        ->get();
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);
    
        $roleId = $request->input('role_id');
        $user->roles()->sync([$roleId]);
    
        return redirect()->back()->with('success', 'User role updated successfully.');
    }
}
