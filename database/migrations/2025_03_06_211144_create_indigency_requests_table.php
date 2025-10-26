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
        Schema::create('indigency_requests', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_firstname');
            $table->string('recipient_middlename')->nullable();
            $table->string('recipient_lastname');
            $table->string('representative_firstname');
            $table->string('representative_middlename')->nullable();
            $table->string('representative_lastname');
            $table->string('house_number');
            $table->string('barangay')->default('Lawang Bato');
            $table->string('city')->default('Valenzuela City');
            $table->string('province')->default('Metro Manila');
            $table->string('email');
            $table->string('contact_number');
            $table->text('user_purpose');
            $table->text('actual_purpose')->nullable();
            $table->string('valid_id');
            $table->boolean('data_privacy_agreement')->default(false);
            $table->string('rejecting_reason')->nullable();
            $table->dateTime('request_expires_at')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indigency_requests');
    }
};
