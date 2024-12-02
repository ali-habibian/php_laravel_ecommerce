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
        Schema::table('brands', function (Blueprint $table) {
            // Make the 'name' column unique
            $table->string('name')->unique()->change();

            // Add soft deletes column
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            // Remove the unique constraint from 'name' column
            $table->dropUnique(['name']);

            // Drop the 'deleted_at' column
            $table->dropSoftDeletes();
        });
    }
};

