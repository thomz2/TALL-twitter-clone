<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'background_color',
        'text_color',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
