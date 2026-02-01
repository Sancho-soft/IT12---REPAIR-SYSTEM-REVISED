<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $fillable = ['first_name', 'last_name', 'address', 'phone_no'];

    public function appliances()
    {
        return $this->hasMany(Appliance::class);
    }
}
