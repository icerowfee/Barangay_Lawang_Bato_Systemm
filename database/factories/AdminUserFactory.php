<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminUser>
 */
class AdminUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $birthdate = $this->faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d');

        $firstname = $this->faker->firstName;
        $lastname = $this->faker->lastName;

        // Generate password in format: FLYYMMDD
        $rawPassword = strtoupper(
            Str::substr($firstname, 0, 1) .
            Str::substr($lastname, 0, 1) .
            Carbon::parse($birthdate)->format('ymd')
        );

        // Random date within the current or past 3 months
        $monthsBack = rand(0, 3);
        $createdAt = now()->subMonths($monthsBack)->subDays(rand(0, 28));

        return [
            'firstname' => $firstname,
            'middlename' => $this->faker->optional()->firstName,
            'lastname' => $lastname,
            'birthdate' => $birthdate,
            'age' => Carbon::parse($birthdate)->age,
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make($rawPassword),
            'role' => $this->faker->randomElement([1, 2]),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
