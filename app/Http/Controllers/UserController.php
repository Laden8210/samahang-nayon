<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\UserAccount;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function addUser()
    {
        return view('admin.user.add');
    }

    public function updateUser($userId){

        $employee = Employee::where('EmployeeId', $userId)->firstOrFail();
        return view('admin.user.update', compact('employee'));
        // try {
        //     $decryptedId = Crypt::decrypt($userId);

        // } catch (DecryptException $e) {
        //     return redirect()->route('user')->with('error', 'Invalid Employee ID.');
        // }
    }

    public function settings()
    {
        return view('admin.user.setting');
    }
}
