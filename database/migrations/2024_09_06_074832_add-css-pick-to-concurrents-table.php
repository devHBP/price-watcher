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
        Schema::table('concurrents', function(Blueprint $table){
            $table->string('css_pick_designation')->nullable()->after('url');
            $table->string('css_pick_prix')->nullable()->after('css_pick_designation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concurrents', function (Blueprint $table){
            $table->dropColumn('css_pick_designation');
            $table->dropColumn('css_pick_prix');
        });
    }
};
