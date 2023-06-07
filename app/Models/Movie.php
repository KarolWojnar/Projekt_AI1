<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies'; // Nazwa tabeli w bazie danych

    protected $fillable = [
        'title', 'description', 'genre', 'director', 'release', 'longTime', 'rate', 'img_path', 'available'
    ];
}
