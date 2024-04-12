<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function showProfile(string $username): View
    {
        $user = User::where('name', $username)
            ->first();
        return view('user.profile', [
            'user' => $user
        ]);
    }

    public function configProfile(string $username)
    {
        $user = User::where('name', $username)
            ->first();
        if (!Auth::check() || Auth::user()->id != $user->id) return redirect()->route('home');
        return view('user.update', [
            'user'=> $user
        ]);
    }
}
