<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appliance extends Model
{
    protected $fillable = [
        'customer_id',
        'brand',
        'product',
        'model_no',
        'serial_no',
        'date_in',
        'warranty_end',
        'category',
        'status',
        'appliance_size',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
