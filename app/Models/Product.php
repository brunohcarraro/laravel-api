<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    	'nome',
    	'slug',
    	'foto',
    	'preco',
    	'client_id'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
