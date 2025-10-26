<?php

namespace Database\Factories;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CedulaRequestFactory extends Factory
{
    public function definition(): array
    {
        // Define random created_at within the last 3 months and current month
        $monthsBack = rand(0, 3); // 0 = current, 1-3 = previous months
        $createdAt = now()->subMonths($monthsBack)->subDays(rand(0, 28));

        // Determine status based on whether it's the current month
        $status = $monthsBack === 0
            ? $this->faker->randomElement(['Pending', 'Approved', 'Rejected', 'Completed'])
            : $this->faker->randomElement(['Approved', 'Rejected', 'Completed']);

        return [
            'firstname' => $this->faker->firstName,
            'middlename' => $this->faker->optional()->firstName,
            'lastname' => $this->faker->lastName,
            'barangay' => 'Lawang Bato',
            'city' => 'Valenzuela City',
            'province' => 'Metro Manila',
            'house_number' => $this->faker->buildingNumber . ', ' . $this->faker->streetName,
            'civil_status' => $this->faker->randomElement(['Single', 'Married', 'Widowed']),
            'birthplace' => $this->faker->city,
            'birthdate' => $birthdate = $this->faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'age' => Carbon::parse($birthdate)->age,
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'email' => $this->faker->unique()->safeEmail,
            'contact_number' => '09' . $this->faker->numerify('#########'),
            // 'years_stay' => $this->faker->optional()->numberBetween(1, 20),
            'tin' => $this->faker->optional()->numerify('###-###-###'),
            'gross_income' => $this->faker->optional()->randomFloat(2, 10000, 500000),
            'valid_id' => $this->faker->randomElement([
                'templates/sampleIds/sample-sssID1.jpg',
                'templates/sampleIds/sample-tinID1.jpg',
                'templates/sampleIds/sample-pagibigID1.jpg',
                'templates/sampleIds/sample-validID1.jpg',
            ]),
            'data_privacy_agreement' => $this->faker->boolean(90), // 90% chance of being true
            'rejecting_reason' => $status === 'Rejected' ? $this->faker->sentence : null,
            'request_expires_at' => $status === 'Approved' ? Carbon::parse($createdAt)->addDays(30) : null,
            'status' => $status,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
    