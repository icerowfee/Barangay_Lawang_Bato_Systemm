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
        Schema::create('job_referral_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('biodata');
            $table->string('cedula');
            $table->string('sss_id');
            $table->string('tin_id');
            $table->string('pagibig_id');
            $table->string('police_clearance');
            $table->string('nbi_clearance');
            $table->string('barangay_clearance');
            $table->string('rejecting_reason')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_referral_requests');
    }
};
