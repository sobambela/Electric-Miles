<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => $this->faker->numberBetween(1, 10),
            'exptected_delivery_time' => date('Y-m-d H:m:i'),  
            'delivery_address' => $this->faker->address,
            'billing_address' => $this->faker->address,
            'status' => 'PENDING'
        ];
    }
}
