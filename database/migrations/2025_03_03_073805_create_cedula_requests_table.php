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
        Schema::create('cedula_requests', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('house_number');
            $table->string('barangay');
            $table->string('city');
            $table->string('province');
            $table->string('civil_status');
            $table->string('birthplace');
            $table->date('birthdate');
            $table->integer('age');
            $table->string('sex');
            $table->string('email');
            $table->string('contact_number');
            $table->string('tin')->nullable();
            $table->decimal('gross_income', 10, 2)->nullable();
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
        Schema::dropIfExists('cedula_requests');
    }
};
