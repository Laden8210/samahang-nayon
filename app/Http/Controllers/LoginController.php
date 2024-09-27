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

        $employee = Employee::where('email', $request->email)->first();



        if (!$employee) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records',
            ])->withInput($request->only('email'));
        }


        if (!Hash::check($request->password, $employee->password)) {
            return back()->withErrors([
                'email' => 'The provided password is incorrect',
            ])->withInput($request->only('email'));
        }

        if ($employee->status == 'Inactive') {
            return back()->withErrors([
                'email' => 'Your account is inactive. Please contact the administrator.',
            ])->withInput($request->only('email'));
        }

        Auth::login($employee);

        $request->session()->regenerate();



        if (Auth::user()->Position == 'System Administrator') {
            return redirect()->intended('admin/');
        } elseif (Auth::user()->Position == 'Receptionist') {
            return redirect()->intended('receptionist/booking');
        }elseif (Auth::user()->Position == 'Manager') {
            return redirect()->intended('manager/promotion/');
        }


        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {

        Auth::logout();
        session()->invalidate();

        return redirect('/');
    }
}
