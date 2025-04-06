<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Movve\Crm\Models\Contact;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'date_of_birth' => $this->faker->optional(0.7)->dateTimeBetween('-80 years', '-18 years'),
            'address' => $this->faker->optional(0.8)->streetAddress(),
            'city' => $this->faker->optional(0.8)->city(),
            'postal_code' => $this->faker->optional(0.8)->postcode(),
            'country' => $this->faker->optional(0.8)->country(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
