<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        // 取出用户id
        $user_ids = User::all()->pluck('id')->toArray();

        // 取出所有话题id
        $topic_ids = Topic::all()->pluck('id')->toArray();

        $faker = app(Faker\Generator::class);

        $replies = factory(Reply::class)
            ->times(100)
            ->make()
            ->each(function ($reply, $index) use ($user_ids, $topic_ids, $faker) {
                $reply->topic_id = $faker->randomElement($topic_ids);
                $reply->user_id = $faker->randomElement($user_ids);
            });

        Reply::insert($replies->toArray());
    }

}

