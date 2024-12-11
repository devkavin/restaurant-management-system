<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concession extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'price'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_concession');
    }
}
