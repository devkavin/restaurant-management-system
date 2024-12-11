<?php

namespace Database\Seeders;

use App\Models\Concession;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $concessions = Concession::factory(100)->create();

        Order::factory()
            ->count(50)
            ->create()
            ->each(function ($order) use ($concessions) {
                $order->concessions()->attach(
                    $concessions->random(rand(1, 3))->pluck('id')->toArray(),
                    ['quantity' => rand(1, 5)]
                );
            });
    }
}
