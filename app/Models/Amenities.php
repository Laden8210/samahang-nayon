<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
    use HasFactory;
    use HasFactory;

    protected $primaryKey = 'AmenitiesId';

    protected $fillable = [
        'Name',
        'Quantity'
    ];

    public function reservationAmenities()
    {
        return $this->hasMany(ReservationAmenities::class, 'AmenitiesId');
    }
}
