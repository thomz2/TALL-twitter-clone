<?php

namespace App\Models;

use App\Observers\LikeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[ObservedBy([LikeObserver::class])]
class Like extends Model
{
    protected $fillable = [
        'user_id',
        'tweet_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tweet(): BelongsTo
    {
        return $this->belongsTo(Tweet::class);
    }
}
