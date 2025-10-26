<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IndigencyRequest>
 */
class IndigencyRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $monthsBack = rand(0, 3); // 0 = current, 1-3 = previous months
        $createdAt = now()->subMonths($monthsBack)->subDays(rand(0, 28));

        $status = $monthsBack === 0
            ? $this->faker->randomElement(['Pending', 'Approved', 'Rejected', 'Completed'])
            : $this->faker->randomElement(['Approved', 'Rejected', 'Completed']);

        $actualPurposes = [
            'Medical', 'Burial', 'Educational', 'Scholarship', "Voter's Certification",
            'DSWD Requirements', 'PSA', 'Solo Parent', 'PWD', '4Ps Requirements',
            'Philhealth', 'Tupad & Tara-Basa'
        ];

        $hasCedula = $this->faker->boolean(70); // 70% chance of having a cedula

        return [
            'recipient_firstname' => $this->faker->firstName,
            'recipient_middlename' => $this->faker->optional()->firstName,
            'recipient_lastname' => $this->faker->lastName,
            'representative_firstname' => $this->faker->firstName,
            'representative_middlename' => $this->faker->optional()->firstName,
            'representative_lastname' => $this->faker->lastName,
            'barangay' => 'Lawang Bato',
            'city' => 'Valenzuela City',
            'province' => 'Metro Manila',
            'house_number' => $this->faker->buildingNumber . ', ' . $this->faker->streetName,
            'email' => $this->faker->unique()->safeEmail,
            'contact_number' => '09' . $this->faker->numerify('#########'),
            'user_purpose' => $this->faker->sentence,
            'actual_purpose' => in_array($status, ['Pending', 'Rejected']) ? null : $this->faker->randomElement($actualPurposes),
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
   