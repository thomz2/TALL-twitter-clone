<?php

namespace App\Livewire;

use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PostTweet extends Component
{

    public $content = "";

    public function postTweet() {
        $this->validate([
            'content' => "required|max:500",
        ]);

        Tweet::create([
            'user_id' => Auth::id(),
            'content' => $this->content,
            // 'bg-color' => '#ff0099',
            // 'text-color' => '#aa77dd',
        ]);

        $this->content = ''; 
        $this->dispatch('tweet-posted'); 
    }

    public function render()
    {
        return view('livewire.post-tweet');
    }
}
