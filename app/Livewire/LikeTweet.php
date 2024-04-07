<?php

namespace App\Livewire;

use App\Models\Like;
use App\Models\Tweet;
use Livewire\Component;

class LikeTweet extends Component
{

    public Tweet $tweet;
    public $countOfLikes;
    public $isLiked;

    public function mount(Tweet $tweet)
    {
        $this->tweet = $tweet;
        $this->countOfLikes = $tweet->likes_count;
        $this->isLiked = $this->isLikedByUser();
    }

    public function isLikedByUser()
    {   
        $user = auth()->user();
        return Like::where('tweet_id', $this->tweet->id)
               ->where('user_id', $user->id)
               ->exists();
    }

    public function likeOrDislikeTweet($liked)
    {
        // dd(auth()->user()->id); // retorna o id do usuario que clicou
        // dd($liked); // retorna se o usuario clicou no alpine
        
        return $liked ? $this->likeTweet() : $this->dislikeTweet(); 
    }

    public function likeTweet()
    {
        $this->countOfLikes++;
        Like::create([
            'user_id' => auth()->user()->id,
            'tweet_id' => $this->tweet->id,
        ]);
        $this->isLiked = true;
    }

    public function dislikeTweet()
    {
        $this->countOfLikes--;
        // Tenho que fazer get()->delete() para ativar o LikeObserver
        Like::where([
            'user_id' => auth()->user()->id,
            'tweet_id' => $this->tweet->id,
        ])->get()[0]->delete();

        $this->isLiked = false;
    }

    public function render()
    {
        return view('livewire.like-tweet');
    }
}
