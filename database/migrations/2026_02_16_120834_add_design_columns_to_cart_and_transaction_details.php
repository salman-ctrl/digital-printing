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
        Schema::table('cart_details', function (Blueprint $table) {
            $table->string('design_option')->default('upload'); // 'upload' or 'tim_kami'
            $table->string('design_difficulty')->nullable(); // 'Simpel', 'Sedang', 'Kompleks'
            $table->decimal('design_cost', 12, 2)->default(0);
        });

        Schema::table('transaction_details', function (Blueprint $table) {
            $table->string('design_option')->default('upload');
            $table->string('design_difficulty')->nullable();
            $table->decimal('design_cost', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_details', function (Blueprint $table) {
            $table->dropColumn(['design_option', 'design_difficulty', 'design_cost']);
        });

        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropColumn(['design_option', 'design_difficulty', 'design_cost']);
        });
    }
};
