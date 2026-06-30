<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StockMovementSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Seed products first.');

            return;
        }

        $reasonsIn = ['Restock', 'Customer Return'];
        $reasonsOut = ['Damaged', 'Lost or Stolen', 'Stock Count Correction'];

        // Generate movements for the past 7 days
        for ($day = 6; $day >= 0; $day--) {
            $date = Carbon::now()->subDays($day);

            // 2 to 6 random movements per day
            $movementsToday = rand(2, 6);

            for ($i = 0; $i < $movementsToday; $i++) {
                $product = $products->random();
                $type = fake()->randomElement(['in', 'out']);
                $quantity = rand(1, 15);

                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => $type,
                    'quantity' => $quantity,
                    'reason' => $type === 'in'
                        ? fake()->randomElement($reasonsIn)
                        : fake()->randomElement($reasonsOut),
                    'notes' => fake()->boolean(40) ? fake()->sentence(6) : null,
                    'user_id' => 1, // your admin user id
                    'created_at' => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                    'updated_at' => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                ]);
            }
        }

        $this->command->info('Seeded fake stock movements for the past 7 days.');
    }
}
