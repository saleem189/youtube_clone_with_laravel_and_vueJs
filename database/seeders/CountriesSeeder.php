<?php

namespace Database\Seeders;

use App\Models\Country;
use File;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();
  
        $json = File::get("database/json_data/countries.json");
        $countries = json_decode($json);
        foreach ($countries as $key => $value) {
            Country::create([
                'id' => $value->id,
                'name' => $value->name,
                'iso3' =>$value->iso3,
                'iso2' =>$value->iso2,
                'numeric_code' =>$value->numeric_code,
                'capital' =>$value->capital,
                'currency_name' =>$value->currency_name,
                'currency_symbol'  =>$value->currency_symbol,
                'region'  =>$value->region,
                'native'  =>$value->native,
                'latitude'  =>$value->latitude,
                'longitude'  =>$value->longitude,
                'emoji'  =>$value->emoji,
                'emojiU'  =>$value->emojiU,
                "timezones"=> $value->timezones
            ]);
           

        }
        
    }
    
}
