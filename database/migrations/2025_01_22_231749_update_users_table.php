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
        Schema::table('users', function (Blueprint $table) {
            $table->string('cellphone')->nullable()->change();
            $table->string('avatar')->nullable()->change();
            $table->string('provider_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cellphone')->nullable(false)->change();
            $table->string('avatar')->nullable(false)->change();
            $table->string('provider_name')->nullable(false)->change();
        });
    }
};
