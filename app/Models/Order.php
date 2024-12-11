<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'send_to_kitchen_time', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function concessions()
    {
        return $this->belongsToMany(Concession::class, 'order_concession')
            ->withPivot('quantity');
    }
}
