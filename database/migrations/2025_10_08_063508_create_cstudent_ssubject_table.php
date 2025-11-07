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
        Schema::create('cstudent_ssubject', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cstudent_id');
            $table->unsignedBigInteger('ssubject_id');
            $table->decimal('fees_paid', 10, 2)->default(0);
            $table->decimal('extra_discount', 5, 2)->default(0);
            $table->date('enrollment_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->enum('status', ['enrolled', 'completed', 'dropped'])->default('enrolled');
            $table->timestamps();

            $table->foreign('cstudent_id')->references('id')->on('cstudents')->onDelete('cascade');
            $table->foreign('ssubject_id')->references('id')->on('ssubjects')->onDelete('cascade');
            
            // Ensure unique combination of student and subject
            $table->unique(['cstudent_id', 'ssubject_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cstudent_ssubject');
    }
};