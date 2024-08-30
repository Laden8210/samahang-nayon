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
