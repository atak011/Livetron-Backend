<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $appends = ['productivity'];

    protected $fillable = ['name', 'slug', 'start_date', 'estimated_end_date',
        'estimated_visitor', 'visitor_limit', 'client_group', 'provider', 'user_id',
        'is_active','participation'];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function getProductivityAttribute(){
        return 0;
    }

}
