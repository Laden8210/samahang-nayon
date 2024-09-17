<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInOut extends Model
{
    use HasFactory;
    protected $primaryKey = 'CheckInOutId';

    protected $table = 'checkinouts';
    public $timestamps = false;

    protected $fillable = [
        'ReservationId',
        'GuestId',
        'DateCreated',
        'TimeCreated',
        'Type'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'ReservationId');
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'GuestId');
    }
}
