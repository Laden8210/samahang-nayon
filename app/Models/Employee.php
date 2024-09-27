<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
class Employee extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'employees';



    public function scopeSearch($query, $value){
        return $query->where(function($q) use ($value) {
            $q->where('FirstName', 'like', '%' . $value . '%')
              ->orWhere('LastName', 'like', '%' . $value . '%')
              ->orWhere('MiddleName', 'like', '%' . $value . '%')
              ->orWhere('Position', 'like', '%' . $value . '%')
              ->orWhere('Status', 'like', '%' . $value . '%')
              ->orWhere('ContactNumber', 'like', '%' . $value . '%')
              ->orWhere('Gender', 'like', '%' . $value . '%')
              ->orWhere('email', 'like', '%' . $value . '%')
              ->orWhere('Username', 'like', '%' . $value . '%');
        });
    }

    protected $primaryKey = 'EmployeeId';

    protected $fillable = [
        'FirstName',
        'LastName',
        'MiddleName',
        'Position',
        'Status',
        'ContactNumber',
        'Gender',
        'Birthdate',
        'Street',
        'Brgy',
        'City',
        'Province',
        'email',
        'UserAccountId',
        'Username',
        'password',
        'DateCreated',
        'TimeCreated'
    ];

    protected $hidden = [
        'password',
    ];

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = Hash::make($value);
    // }

    public function report()
    {
        return $this->hasMany(Report::class, 'EmployeeId');
    }

}
