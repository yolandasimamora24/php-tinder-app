<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Swipe;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function swipes() {
        return $this->hasMany(Swipe::class, 'swiper_id');
    }
    
    public function likedUsers() {
        return $this->belongsToMany(User::class, 'swipes', 'swiper_id', 'swipee_id')
                    ->wherePivot('type', 'like');
    }
    
    public function dislikedUsers() {
        return $this->belongsToMany(User::class, 'swipes', 'swiper_id', 'swipee_id')
                    ->wherePivot('type', 'dislike');
    }
}
