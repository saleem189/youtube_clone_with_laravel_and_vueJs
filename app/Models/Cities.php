<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state_id',
        'country_id',
        'latitude',
        'longitude'
       ];  

    public function cities(){
        return $this->belongsTo(Cities::class);
    }
    public function states(){
        return $this->belongsTo(State::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
   
   
   
}
