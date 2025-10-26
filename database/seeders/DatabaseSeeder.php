<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\AdminUser;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\JobListing;
use App\Models\CedulaRequest;
use Illuminate\Database\Seeder;
use App\Models\ClearanceRequest;
use App\Models\IndigencyRequest;
use App\Models\JobReferralRequest;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        CedulaRequest::factory()->count(50)->create();
        ClearanceRequest::factory()->count(50)->create();
        IndigencyRequest::factory()->count(50)->create();
        User::factory()->count(50)->create();
        // JobReferralRequest::factory()->count(50)->create();
        AdminUser::factory()->count(20)->create();
        Company::factory()
            ->count(5)
            ->has(
                JobListing::factory()
                    ->count(5)
                    ->hasApplicants(10) // each job listing gets 10 applicants
            )
            ->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
