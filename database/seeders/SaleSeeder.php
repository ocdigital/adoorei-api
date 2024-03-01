<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\Product;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = Sale::factory(10)->create();
        $products = Product::all();

        $sales->each(function ($sale) use ($products) {
            $sale->products()->attach(
                $products->random(rand(1, 5))->pluck('id')->toArray(),
                ['amount' => rand(1, 10)]
            );
        });
    }
}
