<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $primaryKey = 'RoomId';
    public $timestamps = false;

    protected $fillable = [
        'Description',
        'RoomNumber',
        'RoomType',
        'RoomPrice',
        'Status',
        'Capacity'
    ];

    public function scopeSearch($query, $value){
        return $query->where('Description', 'like', '%'.$value.'%')
        ->orWhere('RoomNumber', 'like', '%'.$value.'%')
        ->orWhere('RoomType', 'like', '%'.$value.'%')
        ->orWhere('RoomPrice', 'like', '%'.$value.'%')
        ->orWhere('Status', 'like', '%'.$value.'%')
        ->orWhere('Capacity', 'like', '%'.$value.'%');
    }

    public function roomPictures()
    {
        return $this->hasMany(RoomPictures::class, 'RoomId', 'RoomId');
        }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'RoomId');
    }

    public function discountedRooms()
    {
        return $this->hasMany(DiscountedRoom::class, 'RoomId');
    }
}
