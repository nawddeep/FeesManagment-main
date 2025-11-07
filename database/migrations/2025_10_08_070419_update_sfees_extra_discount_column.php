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
        Schema::table('sfees', function (Blueprint $table) {
            // Change extra_discount from decimal(5,2) to decimal(10,2) to allow larger values
            $table->decimal('extra_discount', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sfees', function (Blueprint $table) {
            // Revert back to decimal(5,2)
            $table->decimal('extra_discount', 5, 2)->nullable()->change();
        });
    }
};