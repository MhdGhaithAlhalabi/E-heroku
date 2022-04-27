<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_Customers extends Model
{
    protected $table = 'users_customers';
    protected $fillable = ['user_id','customer_id'];
    use HasFactory;
    public function cart(){
        return $this->hasMany(Cart::class,'user_customer_id');
    }
}
