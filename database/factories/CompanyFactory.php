<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            // Company Registration Details
            'company_name' => $this->faker->company(),
            'business_type' => $this->faker->randomElement([
                'Manufacturing', 'Retail', 'Information Technology', 
                'Construction', 'Healthcare', 'Education', 'Finance'
            ]),
            'street_address' => $this->faker->streetAddress(),
            'barangay' => $this->faker->randomElement([
                'Lawang Bato', 'Malanday', 'Balangkas', 'Pariancillo Villa'
            ]),
            'city' => $this->faker->city(),
            'contact_person_name' => $this->faker->name(),
            'contact_person_position' => $this->faker->jobTitle(),
            'contact_person_email' => $this->faker->unique()->safeEmail(),
            'contact_person_contact_number' => '09' . $this->faker->numerify('#########'),
            'account_email' => $this->faker->unique()->companyEmail(),
            'password' => Hash::make('password123'), // default fake password

            // Additional details
            'description' => $this->faker->optional()->paragraph(),
            // Removed website & logo as per schema note

            // Verification fields
            'registration_document' => 'uploads/registration/' . Str::random(10) . '.pdf',
            'contact_person_valid_id' => 'uploads/ids/' . Str::random(10) . '.jpg',
            'verified_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'verified_by' => null, // leave null unless you want to attach an admin
            'status' => $this->faker->randomElement(['Pending', 'Verified', 'Rejected']),
            'reject_reason' => null,
        ];
    }
}
