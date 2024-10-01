<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'report';
    protected $primaryKey = 'ReportId';
    public $timestamps = false;
    protected $fillable = [
        'ReportName',
        'EmployeeId',
        'Date',
        'type',
        'EndDate',
        'CreatedAt'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'EmployeeId');
    }

}
