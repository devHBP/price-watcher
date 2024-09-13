<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produits extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation',
        'ean',
        'pvp',
        'm_pvp',
        'categorie_id'
    ];

    protected $primaryKey = 'id';

    public function concurrents()
    {
        return $this->hasMany(ProduitsConcurrents::class, "produit_id");
    }

    public function categorie()
    {
        return $this->belongsTo(Categories::class);
    }
}
