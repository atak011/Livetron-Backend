<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRef extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'image',
        'name',
        'promote',
        'event_id',
        'participation',
    ];
}
