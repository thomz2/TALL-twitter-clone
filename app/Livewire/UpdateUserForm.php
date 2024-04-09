<?php

namespace App\Livewire;

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
            'name' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            // 'password' => ['required', 'min:8', 'same:passwordConfirmation'],
        ]);
        
        $this->user->name = $this->name;
        $this->user->email = $this->email;
        if ($this->password) 
            $this->user->password = $this->password;
        dd($this->user);
        $this->user->save();


        return redirect(route('users.show', ["username" => $this->user->name]))
            ->with('success', 'Usuário alterado com sucesso!');
    }

    public function render()
    {
        return view('livewire.update-user-form', );
    }
}
