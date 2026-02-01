<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'report_id',
        'parts_total',
        'labor_total',
        'total_amount',
        'payment_status',
        'payment_date',
        'received_by'
    ];

    protected $casts = ['payment_date' => 'date'];

    public function report()
    {
        return $this->belongsTo(ServiceReport::class, 'report_id');
    }
}
