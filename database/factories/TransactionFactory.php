<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date'          => $this->faker->date,
            'from_user_id'  => User::factory(),
            'to_user_id'    => User::factory(),
            'from_currency' => $this->faker->randomElement(['USD', 'AUD', 'INR', 'BDT', 'EUR', "CAD"]),
            'to_currency'   => $this->faker->randomElement(['USD', 'AUD', 'INR', 'BDT', 'EUR', "CAD"]),
            'from_amount'   => $this->faker->randomFloat('2', '10', '100'),
            'to_amount'     => $this->faker->randomFloat('2', '10', '100'),
        ];
    }
}
