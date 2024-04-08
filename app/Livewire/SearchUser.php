<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class SearchUser extends Component
{

    public $query = '';
    public $users = [];
    
    public function updatedQuery()
    {
        $this->users = User::where('name', 'like', '%'.$this->query.'%')
            ->limit(10)
            ->get()
            ->toArray();
    }
    
    public function render()
    {
        return view('livewire.search-user');
    }
}
