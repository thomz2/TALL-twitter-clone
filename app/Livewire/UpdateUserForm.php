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
        $this->validate([
            'name' => ['unique:users,name,' . $this->user->id, 'required'],
            'bio' => ['required', 'max:50'],
            'email' => ['unique:users,email,' . $this->user->id, 'required', 'email'],
            'password' => ['sometimes', 'min:8', 'same:passwordConfirmation'],
            'profile_img' => 'sometimes|nullable|image|max:1024',
            'background_img' => 'sometimes|nullable|image|max:1024'
        ]);

        $profile_img_url = null;
        if ($this->profile_img) {
            $profile_img_url = $this->profile_img->store('profile_img', 's3');
            //                                                          :8900 ONLY FOR PRODUCTION
            $profile_img_url = str_replace(["8989", "80"], "8900", url(":8900" . "mdwitter/" . $profile_img_url));
        }

        $background_img_url = null;
        if ($this->background_img) {
            $background_img_url = $this->background_img->store('background_img', 's3');
            //                                                             :8900 ONLY FOR PRODUCTION
            $background_img_url = str_replace(["8989", "80"], "8900", url(":8900" . "mdwitter/" . $background_img_url));
        }

        $this->user->update([
            'name' => $this->name,
            'bio' => $this->bio,
            'email' => $this->email,
        ]);

        if (isset($profile_img_url)) {
            // try {
            //     Storage::disk('s3')->delete(substr($this->user->img_url, strlen('http://localhost:8900/mdwitter/')));
            // } catch (\Exception $e) {}
            $this->user->update([
                'img_url' => $profile_img_url
            ]);
        }

        if (isset($background_img_url)) {
            // try {
            //     Storage::disk('s3')->delete(substr($this->user->background_url, strlen('http://localhost:8900/mdwitter/')));
            // } catch (\Exception $e) {}
            $this->user->update([
                'background_url' => $background_img_url
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
