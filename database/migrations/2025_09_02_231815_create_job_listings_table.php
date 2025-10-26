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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            // Job Details
            $table->string('job_id')->unique();
            $table->string('job_title');
            $table->string('job_category')->nullable();
            $table->text('job_description');
            $table->string('job_location');

            // Salary and Employment Details
            $table->decimal('min_salary', 10, 2)->nullable();
            $table->decimal('max_salary', 10, 2)->nullable();
            $table->string('employment_type')->nullable()->default('Full-time'); // e.g., Full-time, Part-time, Contract
            $table->dateTime('application_deadline')->nullable();


            // Requirements
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->decimal('min_height', 5, 2)->nullable(); // cm
            $table->decimal('max_height', 5, 2)->nullable(); // cm
            $table->decimal('min_weight', 5, 2)->nullable(); // kg
            $table->decimal('max_weight', 5, 2)->nullable(); // kg
            $table->string('educational_attainment')->nullable();
            $table->string('special_program')->nullable();
            $table->string('certificate_number')->nullable();
            $table->string('is_special_program_optional')->nullable();

            $table->text('rejecting_reason')->nullable();

            $table->foreignId('posted_by')->constrained('companies')->cascadeOnDelete();
            $table->enum('status', ['Pending', 'Active', 'Closed'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
