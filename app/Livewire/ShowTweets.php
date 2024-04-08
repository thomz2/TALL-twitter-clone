<?php

namespace App\Livewire;

use App\Models\Like;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowTweets extends Component
{

    public $tweets = [];
    public $user;

    public function mount($user = null) {
        $this->$user = $user;
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
    public function reloadTweets()
    {
        if ($this->user)
            $this->tweets = Tweet::latest()->where('user_id', $this->user->id)->get();
        else if (Auth::check()){            
            $this->tweets = Tweet::latest()
                ->whereIn(
                    'user_id',
                    Auth::user()->following()->get()->pluck('id')->add(Auth::user()->id)
                    //                                pluck ~= map
                )
                ->get();
        } else {
            $this->tweets = Tweet::latest()->get();
        }
    }

    public function render()
    {
        return view('livewire.show-tweets', [
            'tweets' => $this->tweets,
        ]);
    }
}
