<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->decimal('price_paid', 10, 2)->default(0)->after('value');
            $table->integer('copies_owned')->default(1)->after('quantity');
            $table->integer('copies_wanted')->default(1)->after('copies_owned');
        });
    }

    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn(['price_paid', 'copies_owned', 'copies_wanted']);
        });
    }
};