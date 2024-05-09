<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
        'foto',
        'sexo',
        'cep',
        'logradouro',
        'numero',
        'cidade',
        'estado',
        'complemento',
        'user_id'
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
