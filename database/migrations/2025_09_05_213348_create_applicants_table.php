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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_listing_id')->constrained('job_listings')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // assuming applicants are users
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('educational_attainment')->nullable();
            $table->string('special_program')->nullable();
            $table->string('certificate_number')->nullable();
            $table->string('resume')->nullable();
            $table->string('valid_id')->nullable();
            $table->string('secondary_valid_id')->nullable();
            $table->string('rejecting_reason')->nullable();
            $table->enum('status', ['Applied', 'Shortlisted', 'Rejected', 'Rejected by Company', 'Accepted by Company'])->default('Applied');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
