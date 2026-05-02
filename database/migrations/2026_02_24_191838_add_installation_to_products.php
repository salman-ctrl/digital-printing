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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'installation_available')) {
                $table->boolean('installation_available')->default(false);
            }

            if (!Schema::hasColumn('products', 'installation_price')) {
                $table->decimal('installation_price', 12, 2)->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['installation_available','installation_price']);
        });
    }    
};
