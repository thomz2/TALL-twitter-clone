<?php

namespace App\Observers;

use App\Models\Like;
use App\Models\Tweet;

class LikeObserver
{
    /**
     * Handle the Like "created" event.
     */
    public function created(Like $like): void
    {
        $tweet = Tweet::find($like->tweet_id);
        $tweet->increment("likes_count");
    }

    /**
     * Handle the Like "deleted" event.
     */
    public function deleted(Like $like): void
    {
        $tweet = Tweet::find($like->tweet_id);
        $tweet->decrement("likes_count");
    }

}
