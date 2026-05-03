<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cart_details', function (Blueprint $table) {
            if (!Schema::hasColumn('cart_details', 'design_file')) {
                $table->string('design_file')->nullable();
            }
        });
        Schema::table('transaction_details', function (Blueprint $table) {
            if (!Schema::hasColumn('transaction_details', 'design_file')) {
                $table->string('design_file')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('cart_details', function (Blueprint $table) {
            $table->dropColumn('design_file');
        });
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropColumn('design_file');
        });
    }
};
