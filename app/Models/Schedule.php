<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'title',
        'title_ne',
        'description',
        'description_ne',
        'image',
        'quantity',
        'start_date',
        'end_date',
        'status',
        'icon',
        'color',
        'mobile_visible'
    ];
}
