<?php

namespace App\Livewire;

use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowTweets extends Component
{

    public $tweets = [];
    public $user;
    public $isAllTweets;
    public $tweetAmount = 5;

    public function mount($user = null) {
        $this->user = $user;
        $this->isAllTweets = false;
        $this->reloadTweets();
    }

    public function updateIsAllTweets($value)
    {
        $this->isAllTweets = $value;
        $this->reloadTweets();
    }

    public function deleteTweet($tweetId) {
        $tweet = Tweet::find($tweetId);
        if ($tweet) {
            $tweet->delete();
            $this->reloadTweets();
        }
    }

    #[On('tweet-posted')]
    public function addCurrentUserNewTweet($tweetId)
    {
        $this->tweets->prepend(Tweet::find($tweetId)[0]);
    }

    public function reloadTweets()
    {
        $tweetsQueryBuilder = Tweet::latest();

        if ($this->user)
            $this->tweets = $tweetsQueryBuilder->where('user_id', $this->user->id)->get();
        else if (Auth::check() && !$this->isAllTweets){   
            $this->tweets = $tweetsQueryBuilder
                ->whereIn(
                    'user_id',
                    Auth::user()
                        ->following()
                        ->get()
                        ->pluck('id')
                        // pluck ~= map
                )
                ->get();
        } else {
            $this->tweets = $tweetsQueryBuilder->get();
        }
    }

    public function render()
    {
        return view('livewire.show-tweets', [
            'tweets' => $this->tweets,
        ]);
    }
}
