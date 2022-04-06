<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $fillable = [
     'name',
     'state_code',
     'latitude',
     'longitude',
     'country_name',
     'country_id'
    ];  

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
           
}
