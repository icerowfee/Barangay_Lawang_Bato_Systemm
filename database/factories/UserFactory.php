<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

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
            ? $this->faker->randomElement(['Pending', 'Active', 'Rejected'])
            : $this->faker->randomElement(['Active', 'Rejected']);

        $birthdate = $this->faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d');

        return [
            'firstname' => $this->faker->firstName,
            'middlename' => $this->faker->optional()->firstName,
            'lastname' => $this->faker->lastName,
            'barangay' => 'Lawang Bato',
            'city' => 'Valenzuela City',
            'province' => 'Metro Manila',
            'house_number' => $this->faker->buildingNumber . ', ' . $this->faker->streetName,
            'civil_status' => $this->faker->randomElement(['Single', 'Married', 'Widowed']),
            'birthdate' => $birthdate,
            'age' => Carbon::parse($birthdate)->age,
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'email' => $this->faker->unique()->safeEmail,
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
            'contact_number' => '09' . $this->faker->numerify('#########'),
            'password' => Hash::make('123123123'),
            'rejecting_reason' => $status === 'Rejected' ? $this->faker->sentence : null,
            'status' => $status,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
