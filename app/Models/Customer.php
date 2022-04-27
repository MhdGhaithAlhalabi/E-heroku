<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['first_name','last_name','mac_address','phone_number','points'];
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class,'users_customers');
    }

}
