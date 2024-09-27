<?php

namespace App\Http\Controllers;


use App\Models\Employee;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;
use PHPUnit\Event\Telemetry\System;

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
            SystemLog::create([
                'log' => 'Login failed from IP: ' . FacadesRequest::ip() . ' for email: ' . $request->email,
                'action' => 'Login Failed',

                'date_created' => date('Y-m-d')
            ]);
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records',
            ])->withInput($request->only('email'));


        }


        if (!Hash::check($request->password, $employee->password)) {
            SystemLog::create([
                'log' => 'Login failed from IP: ' . FacadesRequest::ip() . ' for email: ' . $request->email . ' - Reason: Incorrect password',
                'action' => 'Login Failed',
                'date_created' => now()->toDateString(),
            ]);
            return back()->withErrors([
                'email' => 'The provided password is incorrect',
            ])->withInput($request->only('email'));
        }

        if ($employee->status == 'Inactive') {
            SystemLog::create([
                'log' => 'Login failed from IP: ' . FacadesRequest::ip() . ' for email: ' . $request->email . ' - Reason: Account inactive',
                'action' => 'Login Failed',
                'date_created' => now()->toDateString(),
            ]);
            return back()->withErrors([
                'email' => 'Your account is inactive. Please contact the administrator.',
            ])->withInput($request->only('email'));
        }


        Auth::login($employee);

        $request->session()->regenerate();


        if (Auth::user()->Position == 'System Administrator') {
            SystemLog::create([
                'log' => 'System Administrator logged in from IP: ' . FacadesRequest::ip() . ' for email: ' . $request->email,
                'action' => 'Login',
                'date_created' => date('Y-m-d'),  // More idiomatic date handling
            ]);
            return redirect()->intended('admin/');
        } elseif (Auth::user()->Position == 'Receptionist') {
            SystemLog::create([
                'log' => 'Receptionist logged in from IP: ' . FacadesRequest::ip() . ' for email: ' . $request->email,
                'action' => 'Login',
                'date_created' => date('Y-m-d'),
            ]);
            return redirect()->intended('receptionist/booking');
        } elseif (Auth::user()->Position == 'Manager') {
            SystemLog::create([
                'log' => 'Manager logged in from IP: ' . FacadesRequest::ip() . ' for email: ' . $request->email,
                'action' => 'Login',
                'date_created' => date('Y-m-d'),
            ]);
            return redirect()->intended('manager/promotions/');
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
