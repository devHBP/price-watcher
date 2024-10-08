<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriquePrixProduits extends Model
{
    use HasFactory;

    protected $fillable = [
        'prix',
        'is_below_srp',
        'produit_concurrent_id'
    ];

    public function produitConcurrent()
    {
        return $this->belongsTo(ProduitsConcurrents::class);
    }
}
