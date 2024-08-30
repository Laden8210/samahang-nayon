<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'ReservationId';
    protected $table = 'reservations';
    public $timestamps = false;

    protected $fillable = [
        'GuestId',
        'RoomId',
        'DateCreated',
        'TimeCreated',
        'DateCheckIn',
        'DateCheckOut',
        'Disburse',
        'Balance',
        'Status'
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'GuestId');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'RoomId');
    }

    public function reservationAmenities()
    {
        return $this->hasMany(ReservationAmenities::class, 'ReservationId');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'ReservationId');
    }

    public function checkInOuts()
    {
        return $this->hasMany(CheckInOut::class, 'ReservationId');
    }
}
