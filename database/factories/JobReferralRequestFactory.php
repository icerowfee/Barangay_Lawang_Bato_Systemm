<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobReferralRequest>
 */
class JobReferralRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $monthsBack = rand(0, 3);
        $createdAt = now()->subMonths($monthsBack)->subDays(rand(0, 28));

        $status = $monthsBack === 0
            ? $this->faker->randomElement(['Pending', 'Processing', 'Scheduled', 'Referred', 'Rejected'])
            : $this->faker->randomElement(['Processing', 'Scheduled', 'Referred', 'Rejected']);

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'biodata' => $this->faker->randomElement([
                'templates/sample_resumes/sample-biodata1.pdf',
                'templates/sample_resumes/sample-biodata2.pdf',
                'templates/sample_resumes/sample-biodata3.pdf',
            ]),
            'cedula' => $this->faker->randomElement([
                'templates/sample_ids/sample-cedula1.png',
                'templates/sample_ids/sample-cedula2.png',
                'templates/sample_ids/sample-cedula3.png',
            ]),
            'sss_id' => 'templates/sample_ids/sample-sssID1.jpg',
            'tin_id' => 'templates/sample_ids/sample-tinID1.jpg',
            'pagibig_id' => 'templates/sample_ids/sample-pagibigID1.jpg',
            'police_clearance' => $this->faker->randomElement([
                'templates/sample_resumes/sample-police-clearance1.pdf',
                'templates/sample_resumes/sample-police-clearance2.pdf',
                'templates/sample_resumes/sample-police-clearance3.pdf',
            ]),
            'nbi_clearance' => $this->faker->randomElement([
                'templates/sample_resumes/sample-nbi-clearance1.pdf',
                'templates/sample_resumes/sample-nbi-clearance2.pdf',
                'templates/sample_resumes/sample-nbi-clearance3.pdf',
            ]),
            'barangay_clearance' => $this->faker->randomElement([
                'templates/sample_resumes/sample-barangay-clearance1.pdf',
                'templates/sample_resumes/sample-barangay-clearance2.pdf',
                'templates/sample_resumes/sample-barangay-clearance3.pdf',
            ]),
            'rejecting_reason' => $status === 'Rejected' ? $this->faker->sentence : null,
            'status' => $status,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
