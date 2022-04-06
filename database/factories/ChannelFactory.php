<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->sentence(3),
            'user_id' => function(){
                return $this->factoryForModel(User::class)->create()->id;
            },
            'description' =>$this->faker->sentence(30)


        ];
    }
}
