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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            // Company Registration Details
            $table->string('company_name', 150);
            $table->string('business_type', 150);
            $table->string('street_address', 255);
            $table->string('barangay', 100);
            $table->string('city', 100);
            $table->string('contact_person_name', 100);
            $table->string('contact_person_position', 100);
            $table->string('contact_person_email', 100);
            $table->string('contact_person_contact_number', 11);
            $table->string('account_email', 100)->unique();
            $table->string('password');

            // Additional company details
            $table->text('description')->nullable();

            // Verification fields
            $table->string('registration_document', 255);
            $table->string('contact_person_valid_id', 255);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('admin_users')->nullOnDelete();
            $table->enum('status', ['Pending', 'Verified', 'Rejected'])->default('Pending');
            $table->text('rejecting_reason')->nullable();

            $table->timestamps();
        });

        // Insert default data into the 'companies' table
        if (!DB::table('companies')->where('company_name', 'Example Corp')->exists()) {
            DB::table('companies')->insert([
                'company_name' => 'ABC Corp',
                'business_type' => 'Gray Collar',
                'street_address' => '123 Example Street',
                'barangay' => 'Lawang Bato',
                'city' => 'Valenzuela City',
                'contact_person_name' => 'John Doe',
                'contact_person_position' => 'CEO',
                'contact_person_email' => 'johndoe@example.com',
                'contact_person_contact_number' => '09123456789',
                'account_email' => 'abc@gmail.com',
                'password' => Hash::make('123123123'),
                'description' => 'A leading software development company.',
                'registration_document' => 'doc_12345.pdf',
                'contact_person_valid_id' => 'valid_id_12345.jpg',
                'status' => 'Verified',
                'rejecting_reason' => null,
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
        Schema::dropIfExists('companies');
    }
};
