<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'iso3',
        'iso2',
        'numeric_code',
        'capital',
        'currency_name',
        'currency_symbol',
        'region',
        'native',
        'latitude',
        'longitude',
        'emoji',
        'emojiU',
        'timezones'
    ];
    protected $casts = [
        'timezones' => 'array'
    ];

    public function states(){
        return $this->hasMany(State::class);
    }
    public function cities(){
        return $this->hasMany(Cities::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
   
    // public function setTimezonesAttribute($value)
	// {
	//     $timezones = [];

	//     foreach ($value as $array_item) {
	//         if (!is_null($array_item['key'])) {
	//             $timezones[] = $array_item;
	//         }
	//     }

	//     $this->attributes['timezones'] = json_encode($timezones);
	// }
  
    
}
