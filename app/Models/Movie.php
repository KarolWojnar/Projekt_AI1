<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public $timestamps = false;
    protected $table = 'movies'; // Nazwa tabeli w bazie danych

    protected $fillable = [
        'title', 'description', 'genre', 'director', 'release', 'longTime', 'rate', 'img_path', 'pricePerDay', 'available'
    ];

    public function loans()
    {
        return $this->belongsToMany(Loan::class, 'loan_movie', 'movie_id', 'loan_id');
    }
}
