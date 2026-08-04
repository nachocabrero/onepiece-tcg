<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('notes');
            $table->string('color')->nullable()->after('image_url'); // 赤, 緑, 青, 紫, 黒, 黄
            $table->string('block_icon')->nullable()->after('color'); // 1-5, X
            $table->string('attribute')->nullable()->after('block_icon'); // 海賊, 海軍, etc.
            $table->string('feature')->nullable()->after('attribute'); // 特徴
            $table->text('text')->nullable()->after('feature'); // Efecto/habilidad
            $table->boolean('is_alt')->default(false)->after('text'); // Carta alternativa
            $table->boolean('is_collected')->default(false)->after('is_alt'); // Si está en la colección
        });
    }

    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn(['image_url', 'color', 'block_icon', 'attribute', 'feature', 'text', 'is_alt', 'is_collected']);
        });
    }
};