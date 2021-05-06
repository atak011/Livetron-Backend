<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'price', 'image', 'video', '3d_and',
        '3d_ios', 'conf', 'attributes', 'label', 'brand', 'category', 'omnitron_id', 'event_id'];

    protected $casts = [
        'conf' => 'array',
        'attributes' => 'array'
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }

}
