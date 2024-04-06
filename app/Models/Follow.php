<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follow extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'follower_id'
    ];

    // Acho que nao preciso criar mais funcoes aqui, soh preciso deixar o fillable para caso eu crie uma linha na mao
}
