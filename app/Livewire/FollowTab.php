<?php

namespace App\Livewire;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FollowTab extends Component
{
    public $user;
    public $followers; 
    public $following;
    public $isFollowed;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->followers = $this->user->followers()->count(); 
        $this->following = $this->user->following()->count(); 
        $this->isFollowed = $this->authUserIsFollowing();
    }

    public function authUserIsFollowing()
    {
        $authUser = auth()->user();
        if (!isset($authUser)) return false;
        return Follow::where('user_id', $authUser->id)
            ->where('follower_id', $this->user->id)
            ->exists();
    }

    public function followOrUnfollowUser()
    {
        return $this->isFollowed ? $this->followUser() : $this->unfollowUser();
    }

    public function followUser()
    {
        // Auth::user()->following()->attach($this->user->id);
        Follow::create([
            'user_id' => $this->user->id,
            'follower_id' => Auth::user()->id 
        ]);
        $this->followers++;    
    }

    public function unfollowUser()
    {
        // Auth::user()->following()->detach($this->user->id);    
        Follow::where([
            'user_id' => $this->user->id,
            'follower_id' => Auth::user()->id 
        ])->get()[0]->delete();
        $this->followers--;    
    }

    public function render()
    {
        return view('livewire.follow-tab');
    }
}
