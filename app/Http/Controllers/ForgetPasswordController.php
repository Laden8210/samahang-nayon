<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{

    public function index()
    {
        return view('forget-password.index');
    }

    public function resetPassword()
    {
        return view('forget-password.reset-password');
    }

    public function passwordChanged()
    {
        return view('forget-password.changed-password');
    }

}
