<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'loan_movie', 'loan_id', 'movie_id');
    }
}
