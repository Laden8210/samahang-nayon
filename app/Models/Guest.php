<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guest extends Authenticatable
{
    use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'GuestId';

    public $timestamps = false;

    protected $fillable = [
        'FirstName',
        'LastName',
        'MiddleName',
        'Street',
        'Brgy',
        'City',
        'Province',
        'Birthdate',
        'Gender',
        'ContactNumber',
        'EmailAddress',
        'password',
        'DateCreated',
        'TimeCreated',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'GuestId');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'GuestId');
    }

    public function checkInOuts()
    {
        return $this->hasMany(CheckInOut::class, 'GuestId');
    }
}
