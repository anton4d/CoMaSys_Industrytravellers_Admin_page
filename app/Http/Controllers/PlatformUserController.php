<?php

namespace App\Http\Controllers;

use App\Models\PlatformUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlatformUserController extends Controller
{
    public function index()
    {
        $verified = PlatformUser::verified()->orderBy('name')->get();

        $needsVerification = PlatformUser::where('is_verified', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return inertia('Users/Index', [
            'verified'          => $verified,
            'needsVerification' => $needsVerification,
        ]);
    }

    public function showVerify(PlatformUser $user)
    {
        return inertia('Users/Verify', [
            'user' => $user,
        ]);
    }

    public function verify(PlatformUser $user)
    {
        $user->update([
            'is_verified'              => true,
            'verifi_email_verified_at' => now(),
        ]);

        if (!$user->id_photo_path && $user->verifi_email) {
            $domain = substr(strrchr($user->verifi_email, '@'), 1);

            $exists = DB::table('accepted_email_domains')
                ->where('domain', $domain)
                ->exists();

            if (!$exists) {
                DB::table('accepted_email_domains')->insert([
                    'domain'     => $domain,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'User verified successfully!');
    }

    public function deny(PlatformUser $user)
    {
        $user->update([
            'is_verified'              => false,
            'verifi_email_verified_at' => null,
        ]);

        return redirect()->route('users.index')->with('success', 'User verification denied.');
    }
}