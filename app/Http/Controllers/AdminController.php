<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
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
        return redirect()->route('dashboard')->with('success', 'Admin user created!');
    }
}
