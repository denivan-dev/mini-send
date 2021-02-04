<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'status' => 'posted'
    ];

    public function mail(){
        return $this->belongsTo(Mail::class);
    }
}
