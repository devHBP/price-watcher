<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesUrlConcurrents extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'url_complement',
        'concurrent_id'
    ];

    public function concurrent()
    {
        return $this->belongsTo(Concurrents::class);
    }
}
