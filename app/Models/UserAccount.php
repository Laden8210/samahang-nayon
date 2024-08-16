<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'useraccounts';

    protected $fillable = [
        'Username',
        'EmailAddress',
        'Password',
        'AccountType',
        'Status',
        'DateCreated',
        'TimeCreated'
    ];

    public function guests()
    {
        return $this->hasOne(Guest::class, 'UserAccountId');
    }

    public function employees()
    {
        return $this->hasOne(Employee::class, 'UserAccountId', 'UserAccountId');
    }


}
