<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concurrents extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'url',
        'css_pick_designation',
        'css_pick_prix'
    ];

    public function categorieUrlConcurrent()
    {
        return $this->hasMany(CategoriesUrlConcurrents::class, 'concurrent_id');
    }

    public function produits()
    {
        return $this->hasMany(ProduitsConcurrents::class);
    }
}
