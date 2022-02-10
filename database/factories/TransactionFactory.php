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
        $to_user   = User::factory();
        $from_user = User::factory();
        return [
            'date'          => $this->faker->date,
            'from_user_id'  => $from_user,
            'to_user_id'    => $to_user,
            'from_currency' => $this->faker->randomElement(['USD', 'AUD', 'INR', 'BDT', 'EUR', "CAD"]),
            'to_currency'   => $this->faker->randomElement(['USD', 'AUD', 'INR', 'BDT', 'EUR', "CAD"]),
            'from_amount'   => $this->faker->randomFloat('2', '10', '100'),
            'to_amount'     => $this->faker->randomFloat('2', '10', '100'),
        ];
    }
}
