<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProgressComment extends Model
{
    protected $fillable = [
        'report_id',
        'progress_key',
        'comment_text',
        'created_by',
        'created_by_name',
    ];

    public function report()
    {
        return $this->belongsTo(ServiceReport::class, 'report_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
