<?php

namespace App\Livewire;

use Hash;
use Livewire\Component;

class UpdateUserForm extends Component
{
    public $user;
    /** @var string */
    public $name;

    /** @var string */
    public $email;

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    public function mount()
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }
    
    public function updateUser()
    {

        $this->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'same:passwordConfirmation'],
        ]);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        
        return redirect(route('users.show', ["username" => $this->user->name]))
            ->with('success', 'Usuário alterado com sucesso!');
    }

    public function render()
    {
        return view('livewire.update-user-form');
    }
}
