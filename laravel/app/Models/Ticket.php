<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'seat_id',
        'fila',
        'columna',
        'preu',
        'email'
    ];

}