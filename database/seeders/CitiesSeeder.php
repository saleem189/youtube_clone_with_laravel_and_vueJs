<?php

namespace Database\Seeders;
use File;
use App\Models\Cities;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cities::truncate();
        $cities_json = File::get("database/json_data/countries_cities.json");
        $cities = json_decode($cities_json);
        foreach($cities as $key => $value){
            
                 Cities::create([
                     'id'=>$value->id,
                    'name'=> $value->name,
                    'state_id'=>$value->state_id,
                    'country_id'=> $value->country_id,
                    'latitude'=> $value->latitude,
                    'longitude'=> $value->longitude,
                ]);

            
        }
    }
}
