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
        'is_out_of_stock',
        'is_below_srp',
        'designation_concurrent',
        'css_pick_prix',
        'css_pick_designation',
        'css_pick_badge_rupture',
        'produit_id',
        'concurrent_id',
        'categorie_id',
        'categorie_url_concurrent_id',
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
