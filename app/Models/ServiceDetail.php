<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    protected $fillable = [
        'report_id',
        'service_types',
        'service_charge',
        'date_repaired',
        'date_delivered',
        'complaint',
        'labor',
        'pullout_delivery',
        'parts_total_charge',
        'total_amount',
        'receptionist',
        'manager',
        'technician',
        'released_by'
    ];

    protected $casts = [
        'service_types' => 'array',
        'date_repaired' => 'date',
        'date_delivered' => 'date',
    ];

    public function report()
    {
        return $this->belongsTo(ServiceReport::class, 'report_id');
    }
}
