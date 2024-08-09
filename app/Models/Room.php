<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'number',
        'type',
        'rate',
        'status'
    ];

    public function scopeSearch($query, $value){
        return $query->where('description', 'like', '%'.$value.'%')
        ->orWhere('number', 'like', '%'.$value.'%')
        ->orWhere('type', 'like', '%'.$value.'%')
        ->orWhere('rate', 'like', '%'.$value.'%')
        ->orWhere('status', 'like', '%'.$value.'%')
        ->orWhere('capacity', 'like', '%'.$value.'%');
    }
}
