<?php

namespace Database\Factories;

use App\Models\Video;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->sentence(6),
            'user_id' => function(){
                return $this->factoryForModel(User::class)->create()->id;
            },
            'video_id' => function(){
                return $this->factoryForModel(Video::class)->create()->id;
            },
            'comment_id' => null
        ];
    }
}
