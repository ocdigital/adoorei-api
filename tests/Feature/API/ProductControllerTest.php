<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists_available_products', function () {
    $product = Product::factory()->create();
    $response = $this->getJson('/api/products');
    $response->assertStatus(200);
    $response->assertJsonFragment([
        'name' => $product->name,
        'price' => $product->price,
        'description' => $product->description,
    ]);
});
