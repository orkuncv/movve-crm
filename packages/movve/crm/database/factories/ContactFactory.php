<?php

namespace Movve\Crm\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Movve\Crm\Models\Contact;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
            'date_of_birth' => fake()->date(),
        ];
    }
}
