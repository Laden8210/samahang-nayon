<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomNumber extends Model
{
    use HasFactory;

    protected $table = 'room_number';
    protected $primaryKey = 'room_number_id';
    protected $fillable = ['room_number', 'RoomId'];


    public function room()
    {
        return $this->belongsTo(Room::class, 'RoomId');
    }
}
