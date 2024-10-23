<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Feedback;
use App\Models\FeedbackLike;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $users = User::factory()->count(10)->create();

        Feedback::factory()
            ->count(20)
            ->make()
            ->each(function ($feedback) use ($users) {
                $feedback->user_id = $users->random()->id;
                $feedback->save();
            });

        Feedback::all()->each(function ($feedback) use ($users) {
            $likeCount = rand(1, 5);

            for ($i = 0; $i < $likeCount; $i++) {
                FeedbackLike::factory()->create([
                    'feedback_id' => $feedback->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        });
    }
}
