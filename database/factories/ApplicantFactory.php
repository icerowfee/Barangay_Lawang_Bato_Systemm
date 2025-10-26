<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Applicant;
use App\Models\JobListing;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Applicant>
 */
class ApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Applicant::class;

    public function definition(): array
    {
        $educationalAttainment = $this->faker->randomElement([
            'Basic Education', 
            'High School Undergraduate', 
            'High School Graduate', 
            'College Undergraduate',
            'College Graduate', 
        ]);

        return [
            'job_listing_id' => JobListing::factory(), // auto-create job listing if none exists
            'user_id' => User::factory(), // auto-create user if none exists

            'weight' => $this->faker->numberBetween(50, 90),
            'height' => $this->faker->numberBetween(150, 190),
            'educational_attainment' => $educationalAttainment,
            'special_program' => $this->faker->optional()->randomElement([
                'TESDA NCII',
                'On-the-Job Training',
                'Internship Program',
                'Scholarship Grant',
            ]),
            'certificate_number' => $this->faker->optional()->bothify('CERT-####-####'),

            'resume' => $this->faker->optional()->randomElement([
                '',
                'templates/sample_resumes/sample-resume1.pdf',
                'templates/sample_resumes/sample-resume2.pdf',
                'templates/sample_resumes/sample-resume3.pdf',
            ]),
            'valid_id' => $this->faker->randomElement([
                'templates/sample_ids/sample-sssID1.jpg',
                'templates/sample_ids/sample-tinID1.jpg',
                'templates/sample_ids/sample-pagibigID1.jpg',
                'templates/sample_ids/sample-validID1.jpg',
            ]),
            'secondary_valid_id' => $this->faker->randomElement([
                '',
                'templates/sample_ids/sample-sssID1.jpg',
                'templates/sample_ids/sample-tinID1.jpg',
                'templates/sample_ids/sample-pagibigID1.jpg',
                'templates/sample_ids/sample-validID1.jpg',
            ]),
            
            'rejecting_reason' => null,

            'status' => $this->faker->randomElement([
                'Applied',
                'Shortlisted',
                'Rejected',
                'Rejected by Company',
                'Accepted by Company',
            ]),
        ];
    }
}
