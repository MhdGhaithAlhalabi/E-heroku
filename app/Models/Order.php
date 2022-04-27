<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['menu_id','cart_id','amount'];
    use HasFactory;
    public function cart()
    {
     return   $this->belongsToMany(Cart::class,'orders','cart_id')->withPivot('id','menu_id','amount');
    }

}
