<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;
    protected $table = 'support';
    public $timestamps = false;
    protected $fillable = [
        'email',
        'typeOf',
        'problem',
        'status',
    ];
}
