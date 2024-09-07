<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        return view('site.home', [
            'title' => 'Welcome',
        ]);
    }

    public function changePassword()
    {
        return view('site.change_password');
    }

    public function updatePassword(Request $request)
    {
        // Note: if function validate false, it will auto return $errors in view
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed'],
        ], [
            'current_password.current_password' => 'The current password you entered is incorrect.',
        ]);

        // Update passwor in DB
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success-password', 'Password changed successfully.');
    }
}
