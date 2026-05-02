<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->after('id')->constrained('categories')->onDelete('cascade');
            }
            if (!Schema::hasColumn('categories', 'slug')) {
                $table->string('slug')->unique()->nullable()->after('name');
            }
            if (!Schema::hasColumn('categories', 'image')) {
                $table->string('image')->nullable()->after('slug');
            }
        });

        // Update existing categories to have a slug if they don't have one
        // This is safe to do even if slug column already existed but was empty
        DB::table('categories')->whereNull('slug')->orWhere('slug', '')->get()->each(function ($category) {
            DB::table('categories')->where('id', $category->id)->update([
                'slug' => Str::slug($category->name) . '-' . $category->id
            ]);
        });
        
        // After updating slugs, we can make it non-nullable if we want, but keeping it nullable is safer for now.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'parent_id')) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            }
            if (Schema::hasColumn('categories', 'slug')) {
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('categories', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
