<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Comment;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Video;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user1 = User::factory()->create([
            'email' => 's1@s.com',
            'role_id' =>1
        ]);
        $user2 = User::factory()->create([
            'email' => 's2@s.com',
            'role_id'=>2
        ]);
        $channel1= Channel::factory()->create([ 
            'user_id' => $user1->id
        ]);

        $channel2= Channel::factory()->create([
            'user_id' => $user2->id
        ]);

        $channel1->subscriptions()->create([
            'user_id' => $user2->id
        ]);

        $channel2->subscriptions()->create([
            'user_id' => $user1->id
        ]);

        Subscription::factory(500)->create([
            'channel_id' => $channel1->id
        ]);
        Subscription::factory(500)->create([
            'channel_id' => $channel2->id
        ]);
        $video = Video::factory()->create([
            'channel_id' => $channel1->id
        ]);

        Comment::factory(50)->create([
            'video_id' => $video->id
        ]);
        $comment = Comment::first();
        Comment::factory(10)->create([
            'video_id' => $video->id,
            'comment_id' => $comment->id
        ]);

        
    }
}
