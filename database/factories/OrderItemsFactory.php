<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => $this->faker->numberBetween(1, 10),
            'item_id' => $this->faker->numberBetween(1, 20),
            'quantity' => $this->faker->numberBetween(1, 6)
        ];
    }
}
