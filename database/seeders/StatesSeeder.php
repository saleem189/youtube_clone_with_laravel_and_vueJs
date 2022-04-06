<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use File;
class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::truncate();
        $statesjson = File::get("database/json_data/countries_states.json");
        $states = json_decode($statesjson);
        foreach($states as $key=>$value){
            
                 State::create([
                     'id'=>$value->id,
                    'name'=> $value->name,
                    'state_code'=>$value->state_code,
                    'latitude'=> $value->latitude,
                    'longitude'=> $value->longitude,
                    'country_name'=> $value->country_name,
                    'country_id'=> $value->country_id,
                ]);

            
        }
    }
}
