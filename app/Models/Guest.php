<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $primaryKey = 'GuestId';

    public $timestamps = false;

    protected $fillable = [
        'FirstName',
        'LastName',
        'MiddleName',
        'Street',
        'City',
        'Province',
        'Birthdate',
        'Gender',
        'ContactNumber',
        'EmailAddress',
        'UserAccountId'
    ];

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'UserAccountId');
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
