<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $primaryKey = 'PromotionId';

    protected $fillable = [
        'Promotion',
        'Description',
        'Discount',
        'StartDate',
        'EndDate',
        'DateCreated'
    ];

    public function discountedRooms()
    {
        return $this->hasMany(DiscountedRoom::class, 'PromotionId');
    }
}
