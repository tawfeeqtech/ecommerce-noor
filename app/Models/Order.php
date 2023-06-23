<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tracking_no',
        'fullname',
        'email',
        'phone',
        'pin_code',
        'address',
        'status_message',
        'payment_mode',
        'payment_id',
    ];

    public function orderItems()
    {
        return $this->hasMany(Orderitem::class,'order_id','id');
    }

}
