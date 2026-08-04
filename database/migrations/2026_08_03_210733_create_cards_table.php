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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('set_id')->constrained()->onDelete('cascade');
            $table->foreignId('rarity_id')->nullable()->constrained()->onDelete('set null');
            $table->string('card_number'); // e.g. "OP-01-001", "EB-01-015"
            $table->string('name'); // Character name
            $table->string('character')->nullable(); // Character name for grouping
            $table->string('type')->nullable(); // Character, Event, Stage, etc.
            $table->string('cost')->nullable();
            $table->string('power')->nullable();
            $table->string('health')->nullable();
            $table->string('ability')->nullable();
            $table->string('condition')->default('MT'); // MT, LP, MP, HP, DR
            $table->integer('quantity')->default(1);
            $table->decimal('value', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};