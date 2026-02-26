<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceReport extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'customer_id',
        'customer_name',
        'appliance_id',
        'date_in',
        'status',
        'dealer',
        'dop',
        'date_pulled_out',
        'findings',
        'remarks',
        'location',
        'used_parts'
    ];

    protected $casts = [
        'location' => 'array',
        'date_in' => 'date',
        'dop' => 'date',
        'date_pulled_out' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function appliance()
    {
        return $this->belongsTo(Appliance::class);
    }

    public function details()
    {
        return $this->hasOne(ServiceDetail::class, 'report_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'report_id');
    }

    public function comments()
    {
        return $this->hasMany(ServiceProgressComment::class, 'report_id')->orderBy('created_at', 'asc');
    }

    public function parts()
    {
        return $this->belongsToMany(Part::class)
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
