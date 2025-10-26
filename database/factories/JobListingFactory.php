<?php

namespace Database\Factories;

use App\Models\JobListing;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobListing>
 */
class JobListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   protected $model = JobListing::class;

    public function definition(): array
    {
        $minSalary = $this->faker->numberBetween(10000, 20000);
        $maxSalary = $minSalary + $this->faker->numberBetween(5000, 20000);

        $minAge = $this->faker->numberBetween(18, 25);
        $maxAge = $minAge + $this->faker->numberBetween(5, 15);

        // Educational Attainment options
        $educationalAttainment = $this->faker->randomElement([
            'Basic Education', 
            'High School Undergraduate', 
            'High School Graduate', 
            'College Undergraduate',
            'College Graduate', 
        ]);

        // Special Program (Random name of program)
        $specialProgram = $this->faker->randomElement([
            'Advanced Computer Science',
            'Business Administration',
            'Engineering Technology',
            'Health and Wellness',
            'Data Science',
            'Electrical Engineering'
        ]);

        // Certificate Number (optional)
        $certificateNumber = $this->faker->optional()->randomElement(['on', null]); // Optional field

        // Special Program
        $isSpecialProgramOptional = $this->faker->randomElement(['on', null]);

        return [
            'job_title' => $this->faker->jobTitle(),
            'job_category' => $this->faker->randomElement(['Blue Collar', 'White Collar', 'Pink Collar', 'Green Collar', 'Gray Collar', 'Gold Collar', 'Red Collar', 'Other']),
            'job_description' => $this->faker->paragraphs(10, true),
            'job_location' => $this->faker->city(),

            // Salary and Employment Details
            'min_salary' => $minSalary,
            'max_salary' => $maxSalary,
            'employment_type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Contractual', 'Project-based', 'Internship']),
            'application_deadline' => $this->faker->dateTimeBetween('now', '+3 months'),


            // Requirements
            'min_age' => $minAge,
            'max_age' => $maxAge,
            'min_height' => $this->faker->randomFloat(2, 150, 170),
            'max_height' => $this->faker->randomFloat(2, 171, 190),
            'min_weight' => $this->faker->randomFloat(2, 50, 60),
            'max_weight' => $this->faker->randomFloat(2, 61, 90),
            'educational_attainment' => $educationalAttainment,
            'special_program' => $specialProgram,  // Random program name
            'certificate_number' => $certificateNumber, // Optional certificate number
            'is_special_program_optional' => $isSpecialProgramOptional,

            // Relations
            'posted_by' => Company::factory(), // ensures a company is created if not passed

            // Status
            'status' => $this->faker->randomElement(['Pending', 'Active', 'Closed']),
        ];
    }
}
