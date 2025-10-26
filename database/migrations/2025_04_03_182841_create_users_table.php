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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('barangay')->default('Lawang Bato');
            $table->string('city')->default('Valenzuela City');
            $table->string('province')->default('Metro Manila');
            $table->string('house_number');
            $table->string('civil_status');
            $table->date('birthdate');
            $table->integer('age');
            $table->string('sex');
            $table->string('email');
            $table->string('contact_number');
            $table->string('valid_id');
            $table->string('secondary_valid_id')->nullable();
            $table->string('resume')->nullable();
            $table->string('password');
            $table->string('rejecting_reason')->nullable();
            $table->string('status')->default('Pending');

            $table->timestamps();
        });

        // Insert a default user with all columns populated
        if (!DB::table('users')->where('email', 'anaelmagbag45@gmail.com')->exists()) {
            DB::table('users')->insert([
                'firstname' => 'Anael',
                'middlename' => 'Abalos',
                'lastname' => 'Magbag',
                'barangay' => 'Gen. T. De Leon',
                'city' => 'Valenzuela City',
                'province' => 'Metro Manila',
                'house_number' => '1234 Diam Street',
                'civil_status' => 'Single',
                'birthdate' => '2003-12-14',  // Example birthdate
                'age' => 21,  // Example age
                'sex' => 'Male',
                'email' => 'anaelmagbag45@gmail.com',
                'resume' => 'templates/sample_resumes/sample-resume2.pdf',
                'valid_id' => 'templates/sample_ids/sample-validID1.jpg',
                'secondary_valid_id' => '',
                'contact_number' => '09123456789',
                'password' => Hash::make('123123123'),
                'rejecting_reason' => null,
                'status' => 'Active',  // Changed to 'Active' since it's a default user
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
