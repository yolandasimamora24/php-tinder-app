<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserLikeThresholdReached extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $likeCount; // add this

    public function __construct($user, $likeCount)
    {
        $this->user = $user;
        $this->likeCount = $likeCount; // assign
    }

    public function build()
    {
        return $this->subject('User Reached Likes Threshold')
                    ->view('emails.likes_threshold')
                    ->with([
                        'userName' => $this->user->name,
                        'userEmail' => $this->user->email,
                        'likeCount' => $this->likeCount, // pass to view
                    ]);
    }
}
