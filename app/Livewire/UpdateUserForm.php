<?php

namespace App\Livewire;

use Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateUserForm extends Component
{
    use WithFileUploads;

    public $user;
    public $profile_img;
    public $background_img;
    public $name;
    public $bio;
    public $email;
    public $password = '';
    public $passwordConfirmation = '';

    public function mount()
    {
        $this->name = $this->user->name;
        $this->bio = $this->user->bio;
        $this->email = $this->user->email;
    }
    
    public function updateUser()
    {
        # TODO Colocar umas regras de unicidade
        $this->validate([
            'name' => ['required'],
            'bio' => ['required', 'max:50'],
            'email' => ['required', 'email'],
            'password' => ['sometimes', 'min:8', 'same:passwordConfirmation'],
            'profile_img' => 'sometimes|nullable|image|max:1024'
        ]);

        $profile_img_url = null;
        if ($this->profile_img) {
            $profile_img_url = $this->profile_img->store('profile_img', 's3');
            $profile_img_url = 'https://mdwitter.s3.amazonaws.com/' . $profile_img_url;
        }

        $this->user->update([
            'name' => $this->name,
            'bio' => $this->bio,
            'email' => $this->email,
        ]);

        if (isset($profile_img_url)) {
            Storage::disk('s3')->delete(substr($this->user->img_url, strlen('https://mdwitter.s3.amazonaws.com/')));
            $this->user->update([
                'img_url' => $profile_img_url
            ]);
        }

        if ($this->password)
            $this->user->update([
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
