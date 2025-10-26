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
        Schema::create('barangay_officials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('barangay_official_image');
            $table->string('position');
            $table->timestamps();
        });

        DB::table('barangay_officials')->insert([
            'name' => 'Orestes R. Tolentino',
            'position' => 'Punong Barangay',
            'barangay_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('barangay_officials')->insert([
            'name' => 'Victoriano S. Borcena',
            'position' => 'Barangay Secretary',
            'barangay_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('barangay_officials')->insert([
            'name' => 'Artemio B. Pacheco',
            'position' => 'Barangay Treasurer',
            'barangay_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('barangay_officials')->insert([
            'name' => 'Michael D. Clemente',
            'position' => 'Barangay Kagawad 1',
            'barangay_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('barangay_officials')->insert([
            'name' => 'Maximiana V. Delina',
            'position' => 'Barangay Kagawad 2',
            'barangay_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('barangay_officials')->insert([
            'name' => 'Marlon B. Dalag',
            'position' => 'Barangay Kagawad 3',
            'barangay_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('barangay_officials')->insert([
            'name' => 'Marietta G. Delina',
            'position' => 'Barangay Kagawad 4',
            'barangay_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('barangay_officials')->insert([
            'name' => 'Julius Caesar C. Lamson',
            'position' => 'Barangay Kagawad 5',
            'barangay_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('barangay_officials')->insert([
            'name' => 'Enrico M. De Gucena',
            'position' => 'Barangay Kagawad 6',
            'barangay_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('barangay_officials')->insert([
            'name' => 'Catherine N. Barcelino',
            'position' => 'Barangay Kagawad 7',
            'barangay_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangay_officials');
    }
};
