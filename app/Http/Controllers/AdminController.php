<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showRegister()
    {
        return inertia('Admin/Register');
    }

    public function store(Request $request, CreateNewUser $creator)
    {
        $creator->create($request->all());
        return redirect()->route('admin.index')->with('success', 'Admin user created!');
    }

    public function index()
    {
        $admins = User::get();
        return inertia('Admin/Index', [
            'admins' => $admins
        ]);
    }
    public function destroy(User $admin)
    {
        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'admin deleted!');
    }

    public function edit(User $admin)
    {
        return inertia('admin/Edit', [
            'admin' => $admin->load('info'),
        ]);
    }
}
