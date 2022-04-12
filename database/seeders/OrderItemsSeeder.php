<?php

namespace Database\Seeders;

use App\Models\OrderItems;
use Illuminate\Database\Seeder;

class OrderItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderItems::factory(30)->create();
    }
}
