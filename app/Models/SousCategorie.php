<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousCategorie extends Model
{
    use HasFactory;
    protected $table = 'sous_categorie';

    protected $fillable = [
        'name',
        'sous_sous_categorie_id',
    ];

    public function sousSousCategorie()
    {
        return $this->belongsTo(SousSousCategorie::class);
    }
}
