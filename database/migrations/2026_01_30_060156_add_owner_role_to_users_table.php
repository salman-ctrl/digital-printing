<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddOwnerRoleToUsersTable extends Migration
{
    public function up(): void
    {
        DB::statement(
            "ALTER TABLE users 
             MODIFY role ENUM('admin','owner','user') 
             DEFAULT 'user'"
        );
    }

    public function down(): void
    {
        DB::statement(
            "ALTER TABLE users 
             MODIFY role ENUM('admin','user') 
             DEFAULT 'user'"
        );
    }
}
