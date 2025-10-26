<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('super_admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        if (!DB::table('super_admin_users')->where('email', 'superadmin@gmail.com')->exists()) {
            DB::table('super_admin_users')->insert([
                'firstname' => 'Super',
                'middlename' => 'Bat',
                'lastname' => 'Man',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('superman'),
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
        Schema::dropIfExists('super_admin_users');
    }
};
