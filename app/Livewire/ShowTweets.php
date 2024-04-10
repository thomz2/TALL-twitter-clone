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
    public $tweetAmount = 3;
    public $loads = 0;

    public function mount($user = null) {
        $this->user = $user;
        $this->isAllTweets = false;
        $this->reloadTweets();
    }

    public function updateIsAllTweets($value)
    {
        $this->isAllTweets = $value;
        $this->loads = 0;
        
        // Fazer uma query aqui para pegar os {{ tweetAmount }} primeiros
        $tweetsQueryBuilder = Tweet::latest();
        if (Auth::check() && !$this->isAllTweets) {
            $tweetsQueryBuilder = $tweetsQueryBuilder
                ->whereIn(
                    'user_id',
                    Auth::user()
                        ->following()
                        ->get()
                        ->pluck('id')
                ); 
        }

        $this->tweets = $tweetsQueryBuilder->take($this->tweetAmount)->get();
    }

    public function deleteTweet($tweetId) {
        $tweet = Tweet::find($tweetId);
        if ($tweet) {
            $tweet->delete();
            // Preciso remover assim, pois se eu fizer reload, vai repetir tweets ja existentes
            $this->tweets = $this->tweets->reject(function ($tweet) use ($tweetId) {
                return $tweet->id === $tweetId;
            });
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
            $tweetsQueryBuilder = $tweetsQueryBuilder->where('user_id', $this->user->id);
        else if (Auth::check() && !$this->isAllTweets){   
            $tweetsQueryBuilder = $tweetsQueryBuilder
                ->whereIn(
                    'user_id',
                    Auth::user()
                        ->following()
                        ->get()
                        ->pluck('id')
                        // pluck ~= map
                );
        } 

        $newTweets = $tweetsQueryBuilder->offset($this->tweetAmount*$this->loads)->limit($this->tweetAmount)->get();
        $this->tweets = $this->loads == 0 ? $newTweets : $this->tweets->concat($newTweets);
    }

    public function loadMore()
    {
        $this->loads++;
        $this->reloadTweets();
    }

    public function render()
    {
        return view('livewire.show-tweets', [
            'tweets' => $this->tweets,
        ]);
    }
}
