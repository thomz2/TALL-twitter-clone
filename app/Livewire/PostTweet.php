<?php

namespace App\Livewire;

use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PostTweet extends Component
{

    public $content = "";
    public $text_color = "#1f2937";
    public $background_color = "#ffffff";

    public function postTweet() {
        $this->validate([
            'content' => "required|max:500",
        ]);

        $tweet = Tweet::create([
            'user_id' => Auth::id(),
            'content' => $this->content,
            'background_color' => $this->background_color,
            'text_color' => $this->text_color,
        ]);

        $this->content = ''; 
        $this->dispatch('tweet-posted', ["tweetId" => $tweet->id]); 
    }

    public function render()
    {
        return view('livewire.post-tweet');
    }
}
