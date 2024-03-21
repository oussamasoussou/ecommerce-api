<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $table = 'categorie';

    protected $fillable = [
        'name',
        // 'sous_categorie_id',
        // 'sous_sous_categorie_id',
    ];

    // public function sousSousCategorie()
    // {
    //     return $this->belongsTo(SousSousCategorie::class);
    // }
    // public function sousCategorie()
    // {
    //     return $this->belongsTo(SousCategorie::class);
    // }
}
