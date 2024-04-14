<?php

namespace App\Models;

use App\Observers\FollowObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([FollowObserver::class])]
class Follow extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'follower_id'
    ];

    // Acho que nao preciso criar mais funcoes aqui, soh preciso deixar o fillable para caso eu crie uma linha na mao
}
