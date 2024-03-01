<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

//testar a listagem de produtos
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

//testar resposta vazia
it('list_available_products_empty', function () {
    $response = $this->getJson('/api/products');
    $response->assertStatus(200);
    $response->assertJsonCount(0);
});
