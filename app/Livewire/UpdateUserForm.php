<?php

namespace App\Livewire;

use Hash;
use Livewire\Component;

class UpdateUserForm extends Component
{
    public $user;
    /** @var string */
    public $name;
    public $bio;

    /** @var string */
    public $email;

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    public function mount()
    {
        $this->name = $this->user->name;
        $this->bio = $this->user->bio;
        $this->email = $this->user->email;
    }
    
    public function updateUser()
    {

        $this->validate([
            'name' => ['required'],
            'bio' => ['required', 'max:50'],
            'email' => ['required', 'email'],
            'password' => ['min:8', 'same:passwordConfirmation'],
        ]);

        if ($this->password)
            $this->user->update([
                'name' => $this->name,
                'bio' => $this->bio,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
        else 
            $this->user->update([
                'name' => $this->name,
                'bio' => $this->bio,
                'email' => $this->email,
            ]);
        
        return redirect(route('users.show', ["username" => $this->user->name]))
            ->with('success', 'Usuário alterado com sucesso!');
    }

    public function render()
    {
        return view('livewire.update-user-form');
    }
}
