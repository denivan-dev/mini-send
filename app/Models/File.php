<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = [];

    public function mail(){
        return $this->belongsTo(Mail::class);
    }
}
