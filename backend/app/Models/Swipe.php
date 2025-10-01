<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Swipe extends Model
{
    protected $fillable = ['swiper_id', 'swipee_id', 'type'];

    /**
     * The user who performed the swipe.
     */
    public function swiper(): BelongsTo
    {
        return $this->belongsTo(User::class, 'swiper_id');
    }

    /**
     * The user who got swiped.
     */
    public function swipee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'swipee_id');
    }
}
