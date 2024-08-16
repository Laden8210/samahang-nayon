<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $primaryKey = 'PaymentId';

    protected $fillable = [
        'GuestId',
        'ReservationId',
        'AmountPaid',
        'DateCreated',
        'TimeCreated',
        'Status'
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'GuestId');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'ReservationId');
    }
}
