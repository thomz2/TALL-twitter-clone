<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function show(User $user): View
    {
        return view('user.profile', [
            'user' => $user
        ]);
    }

    public function showProfile(string $username): View
    {
        $user = User::where('name', $username)
                ->first();
        return view('user.profile', [
            'user' => $user
        ]);
    }

    public function configProfile(string $username): View
    {
        $user = User::where('name', $username)
                ->first();
        return view('user.update', [
            'user'=> $user
        ]);
    }
}
