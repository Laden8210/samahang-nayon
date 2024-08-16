<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function scopeSearch($query, $value){
        return $query->where('FirstName', 'like', '%'.$value.'%');
    }

    protected $primaryKey = 'GuestId';

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
        'City',
        'Province',
        'EmailAddress',
        'UserAccountId'
    ];

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'UserAccountId');
    }
}
