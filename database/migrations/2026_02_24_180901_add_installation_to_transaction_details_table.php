<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            if (!Schema::hasColumn('transaction_details', 'need_installation')) {
                $table->boolean('need_installation')->default(false);
            }
            if (!Schema::hasColumn('transaction_details', 'installation_price')) {
                $table->decimal('installation_price', 12, 2)->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropColumn(['need_installation', 'installation_price']);
        });
    }
};
