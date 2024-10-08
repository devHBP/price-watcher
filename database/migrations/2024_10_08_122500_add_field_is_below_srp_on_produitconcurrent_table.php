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
        Schema::table('produits_concurrents', function (Blueprint $table){
            $table->boolean('is_below_srp')->default(false)->after('prix_concurrent');
        });

        Schema::table('historique_prix_produits', function (Blueprint $table){
            $table->boolean('is_below_srp')->default(false)->after('prix');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produits_concurrents', function (Blueprint $table){
            $table->dropColumn(('is_below_srp'));
        });
        Schema::table('historique_prix_produits', function (Blueprint $table){
            $table->dropColumn(('is_below_srp'));
        });
    }
};
