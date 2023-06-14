<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'loans'; // Nazwa tabeli w bazie danych

    protected $fillable = [
        'start_loan',
        'end_loan',
        'price',
        'status',
        'user_id',
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'loan_movie', 'loan_id', 'movie_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
