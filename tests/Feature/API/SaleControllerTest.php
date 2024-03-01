<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Sale;

uses(RefreshDatabase::class);
//testar nova venda
it('cant_store_new_sale', function () {
    $products = Product::factory(2)->create();
    $saleData = [
        'products' => [
            ['id' => $products[0]->id, 'amount' => 1],
            ['id' => $products[1]->id, 'amount' => 1],
        ],
    ];
    $response = $this->postJson('/api/sales', $saleData);
    $response->assertStatus(201);
});

//testar nova venda com produto inexistente
it('cant_store_new_sale_with_nonexistent_product', function () {
    $saleData = [
        'products' => [
            ['id' => 1, 'amount' => 1],
        ],
    ];
    $response = $this->postJson('/api/sales', $saleData);
    $response->assertStatus(422);
});

//testar venda sem produtos
it('cant_store_new_sale_without_products', function () {
    $saleData = [
        'products' => [],
    ];
    $response = $this->postJson('/api/sales', $saleData);
    $response->assertStatus(422);
});

//testar listagem de vendas
it('cant_list_sales', function () {
    $products = Product::factory(2)->create();
    $saleData = [
        'products' => [
            ['id' => $products[0]->id, 'amount' => 1],
            ['id' => $products[1]->id, 'amount' => 1],
        ],
    ];
    $response = $this->postJson('/api/sales', $saleData);
    $response = $this->getJson('/api/sales');
    $response->assertStatus(200);
    $response->assertJsonCount(1); // Apenas uma venda
});




