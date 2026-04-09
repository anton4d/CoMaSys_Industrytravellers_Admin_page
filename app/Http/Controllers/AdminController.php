<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\AdminPermission;

class AdminController extends Controller
{
    public function showRegister()
    {
        return inertia('Admin/Register', ['permissions' => AdminPermission::toArray(),]);
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
            'admins' => $admins,
            'permissions' => AdminPermission::toArray(),
        ]);
    }

    public function destroy(User $admin)
    {
        if (!request()->user()->is_super_admin && $admin->is_super_admin) {
            abort(403, 'Only super admins can delete other super admins.');
        }

        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'Admin deleted!');
    }

    public function update(Request $request, User $admin)
    {
        $currentUser = $request->user();

        // only super admins can modify super admin status
        if (!$currentUser->is_super_admin && $request->boolean('is_super_admin')) {
            abort(403, 'Only super admins can grant super admin status.');
        }

        // only super admins can edit super admins
        if (!$currentUser->is_super_admin && $admin->is_super_admin) {
            abort(403, 'Only super admins can edit other super admins.');
        }

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'confirmed|min:8',
            ]);
            $data['password'] = bcrypt($request->password);
        }

        foreach (AdminPermission::cases() as $permission) {
            // skip is_super_admin for non super admins
            if ($permission === AdminPermission::SuperAdmin && !$currentUser->is_super_admin) {
                continue;
            }
            $data[$permission->value] = $request->boolean($permission->value);
        }

        $admin->update($data);

        return redirect()->route('admin.index')->with('success', 'Admin updated!');
    }

    public function edit(User $admin)
    {
        return inertia('Admin/Edit', [
            'admin' => $admin,
            'permissions' => AdminPermission::toArray(),
        ]);
    }
}
