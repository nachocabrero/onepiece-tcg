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
        Schema::create('sets', function (Blueprint $table) {
            $table->id();
            $table->string('code'); // OP-01, OP-02, EB-01, ST-01, P-001, etc.
            $table->string('name'); // "The New World", "Ace Revolution", etc.
            $table->string('type')->default('main'); // main, event, special, promo
            $table->string('series')->default('base'); // Wano, Egghead, etc.
            $table->integer('release_year')->nullable();
            $table->integer('total_cards')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sets');
    }
};