<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitsConcurrents extends Model
{
    use HasFactory;

    protected $fillable = [
        'url_produit',
        'prix_concurrent',
        'designation_concurrent',
        'css_pick_prix',
        'css_pick_designation',
        'produit_id',
        'concurrent_id',
        'categorie_id',
        'categorie_url_concurrent_id'
    ];

    public function produit()
    {
        return $this->belongsTo(Produits::class);
    }

    public function concurrent()
    {
        return $this->belongsTo(Concurrents::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categories::class); 
    }

    public function categorieUrlConcurrent()
    {
        return $this->belongsTo(CategoriesUrlConcurrents::class);
    }

}
