<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Swipe;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserLikeThresholdReached;

class CheckLikesThreshold extends Command
{
    protected $signature = 'likes:check-threshold';
    protected $description = 'Check users who liked more than 50 people and notify admin';

    public function handle()
    {
        $threshold = 1;
        $adminEmail = 'admin@example.com'; // replace with any email

        // Get users who liked more than threshold
        $users = User::withCount(['swipes as likes_count' => function($query) {
            $query->where('type', 'like');
        }])->having('likes_count', '>', $threshold)->get();

        foreach ($users as $user) {
            Mail::to($adminEmail)->send(new UserLikeThresholdReached($user, $user->likes_count));
            $this->info("Email sent for user {$user->name} with {$user->likes_count} likes.");
        }

        $this->info('Check completed!');
    }
}
