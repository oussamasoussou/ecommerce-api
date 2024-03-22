<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couleur extends Model
{
    use HasFactory;
    protected $table = 'couleur';

    protected $fillable = [
        'name',
        'color_code',
    ];
}
