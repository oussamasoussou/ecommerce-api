<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousSousCategorie extends Model
{
    use HasFactory;
    protected $table = 'sous_sous_categorie';

    protected $fillable = [
        'name'
    ];
}
