<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concurrents extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'url'
    ];
}
