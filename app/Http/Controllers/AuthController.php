<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
	public function login()
	{
		return view('site.login', [
			'title' => 'Sign In',
		]);
	}

	public function authenticate(Request $request)
	{
		$credential = $request->validate([
			'username' => ['required'],
			'password' => ['required'],
		]);
		if (Auth::attempt($credential)) {
			$user = Auth::user();
			$request->session()->regenerate();
			// Save user session
			$request->session()->put('user', [
                'user_id' => $user->user_id,
				'role_id' => $user->role_id,
                'username' => $user->username,
				'name' => $user->name,
                'email' => $user->email,
            ]);
			// dd($request->session()->get('user'));
			// session()->put('user', $user->getAttributes());
			return redirect()->intended('/');    // Note: Intended func to redirect before middleware
		}

		return back()->with([
			'error' => 'Login failed',
		]);
	}

	public function register()
	{
		return view('site.register', [
			'title' => 'Register',
		]);
	}

	public function store(Request $request)
	{
		if ($request->password != $request->repassword) {
			$request->session()->flash('error', 'Password does not same');
			return redirect('register');
		}
		$validated = $request->validate([
			'name' => ['required'],
			'username' => ['required', 'unique:users'],
			'email' => ['required', 'email:dns', 'unique:users'],
			'password' => ['required'],
		]);
		$validated['password'] = Hash::make($request->password);
		$validated['role_id'] = User::ROLE_EDITOR;
		if (!User::create($validated)) {
			$request->session()->flash('error', 'Failed register.');
			return redirect('register');
		}
		return redirect('/login');
	}

	public function logout(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect('/');
	}
}
