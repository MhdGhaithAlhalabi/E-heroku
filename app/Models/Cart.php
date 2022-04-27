<?php

namespace App\Models;

use App\Models\Users_Customers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Cart extends Model
{
    protected $fillable = ['user_customer_id'];
    use HasFactory;

    public function order(){
       return $this->hasMany(Order::class,'cart_id');
    }

    public function users_customers()
    {
       return $this->belongsTo(Users_Customers::class,'users_customers_id');
    }
}

