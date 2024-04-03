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
        else 
            $this->tweets = Tweet::latest()->get();
    }

    public function test($clicked)
    {
        // dd(auth()->user()->id); // retorna o id do usuario que clicou
        // dd($clicked); // retorna se o usuario clicou no alpine
    }

    public function render()
    {
        return view('livewire.show-tweets', [
            'tweets' => $this->tweets,
        ]);
    }
}
