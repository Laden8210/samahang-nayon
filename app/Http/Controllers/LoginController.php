<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    public function index()
    {

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->position == 'System Administrator') {
                return redirect('admin/');
            } else if ($user->position == 'Receptionist') {
                return redirect('receptionist/booking');
            }

        }
        return view('index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->position == 'System Administrator') {
                return redirect()->intended('admin/');
            } else if (Auth::user()->position == 'Receptionist') {
                return redirect()->intended('receptionist/booking');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {

        Auth::logout();
        return redirect('/');
    }
}
