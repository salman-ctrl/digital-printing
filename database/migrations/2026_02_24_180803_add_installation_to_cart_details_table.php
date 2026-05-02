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
            $table->boolean('need_installation')->default(false)->after('design_file');
            $table->decimal('installation_price', 12, 2)->default(0)->after('need_installation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_details', function (Blueprint $table) {
            $table->dropColumn(['need_installation', 'installation_price']);
        });
    }
};
