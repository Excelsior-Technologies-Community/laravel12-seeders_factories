<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modify posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->text('excerpt')->nullable()->change();
        });

        // Modify categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });

        // Modify users table bio column
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Revert posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->string('excerpt', 255)->nullable()->change();
        });

        // Revert categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->string('description', 255)->nullable()->change();
        });

        // Revert users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('bio', 255)->nullable()->change();
        });
    }
};