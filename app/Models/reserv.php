<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reserv extends Model
{
    protected $fillable = [
        'userId', 'vehId', 'date_reservation'
    ];
}
