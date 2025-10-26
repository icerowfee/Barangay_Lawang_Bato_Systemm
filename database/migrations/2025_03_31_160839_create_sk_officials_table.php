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
        Schema::create('sk_officials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sk_official_image');
            $table->string('position');
            $table->timestamps();
        });

        DB::table('sk_officials')->insert([
            'name' => 'Khym Ashley J. Dulatas',
            'position' => 'SK Chairman',
            'sk_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sk_officials')->insert([
            'name' => 'Rico B. Caduldulan',
            'position' => 'SK Secretary',
            'sk_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sk_officials')->insert([
            'name' => 'Jenard Aron R. Delina',
            'position' => 'SK Treasurer',
            'sk_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sk_officials')->insert([
            'name' => 'Jessica Mae T. Torres',
            'position' => 'SK Kagawad 1',
            'sk_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sk_officials')->insert([
            'name' => 'Marinell A. Molina',
            'position' => 'SK Kagawad 2',
            'sk_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sk_officials')->insert([
            'name' => 'Nicole Ellaine P. David',
            'position' => 'SK Kagawad 3',
            'sk_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sk_officials')->insert([
            'name' => 'Arjay C. Martin',
            'position' => 'SK Kagawad 4',
            'sk_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sk_officials')->insert([
            'name' => 'Pocholo David Hans Contreras',
            'position' => 'SK Kagawad 5',
            'sk_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sk_officials')->insert([
            'name' => 'Mikkaella Meigh DP. Manzano',
            'position' => 'SK Kagawad 6',
            'sk_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sk_officials')->insert([
            'name' => 'Alexa Miyuki D. Rodriquez',
            'position' => 'SK Kagawad 7',
            'sk_official_image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_officials');
    }
};
