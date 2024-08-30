<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories_url_concurrents', function(Blueprint $table){
            $table->id();
            $table->string('url_complement');
            $table->foreignId('concurrent_id')->constrained('concurrents')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('produits_concurrents', function(Blueprint $table){
            $table->id();
            $table->string('url_produit');
            $table->decimal('prix_concurrent', 8,2);
            $table->string('designation_concurrent');
            $table->string('css_pick_prix')->nullable();
            $table->string('css_pick_designation')->nullable();
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->foreignId('concurrent_id')->constrained('concurrents')->onDelete('cascade');
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('categorie_url_concurrent_id')->constrained('categories_url_concurrents')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('historique_prix_produits', function(Blueprint $table){
            $table->id();
            $table->decimal('prix', 8,2);
            $table->foreignId('produit_concurrent_id')->nullable()->constrained('produits_concurrents')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_url_concurrents');
        Schema::dropIfExists('produits_concurrents');
        Schema::dropIfExists('historique_prix_produits');
    }
};
