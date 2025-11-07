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
        Schema::table('cstudent_ssubject', function (Blueprint $table) {
            // Add the missing columns that the model expects
            $table->decimal('fees_submitted', 10, 2)->default(0)->after('fees_paid');
            $table->date('date_of_submitted')->nullable()->after('extra_discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cstudent_ssubject', function (Blueprint $table) {
            $table->dropColumn(['fees_submitted', 'date_of_submitted']);
        });
    }
};