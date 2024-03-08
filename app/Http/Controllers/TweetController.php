<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'content' => "required|max:500"
        ]);
    }
}
