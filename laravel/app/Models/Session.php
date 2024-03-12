<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    public function movie(){

    return $this->belongsTo(Movie::class);
    }

    public function seats(){

    return $this->hasMany(Seat::class);
    }
}