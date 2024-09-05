<?php

use App\Models\Produits;
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
        Schema::table('produits', function(Blueprint $table){
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->onDelete('cascade');
        });
        //! Attention en fonction, de la base de donnée pour créer des problèmes de migrations 
        Produits::query()->update(["categorie_id" => 3]);

        Schema::table('produits', function(Blueprint $table){
            $table->foreignId('categorie_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropForeign(['categorie_id']);
            $table->dropColumn('categorie_id');
        });
    }
};
