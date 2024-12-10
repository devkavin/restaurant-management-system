<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConcessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $concessions = [
            [
                'name' => 'Popcorn',
                'description' => 'Freshly popped popcorn',
                'image' => 'placeholder.svg',
                'price' => 5.00
            ],
            [
                'name' => 'Soda',
                'description' => 'Refreshing soda',
                'image' => 'placeholder.svg',
                'price' => 3.00
            ],
            [
                'name' => 'Candy',
                'description' => 'Sweet candy',
                'image' => 'placeholder.svg',
                'price' => 2.00
            ],
            [
                'name' => 'Nachos',
                'description' => 'Cheesy nachos',
                'image' => 'placeholder.svg',
                'price' => 6.00
            ],
            [
                'name' => 'Hot Dog',
                'description' => 'Classic hot dog',
                'image' => 'placeholder.svg',
                'price' => 4.00
            ],
            [
                'name' => 'Ice Cream',
                'description' => 'Cold ice cream',
                'image' => 'placeholder.svg',
                'price' => 3.00
            ],
            [
                'name' => 'Pretzel',
                'description' => 'Salty pretzel',
                'image' => 'placeholder.svg',
                'price' => 4.00
            ],
            [
                'name' => 'Cotton Candy',
                'description' => 'Fluffy cotton candy',
                'image' => 'placeholder.svg',
                'price' => 3.00
            ],
        ];

        foreach ($concessions as $concession) {
            \App\Models\Concession::create($concession);
        }
    }
}
