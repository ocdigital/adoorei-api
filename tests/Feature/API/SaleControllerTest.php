<?php

use App\Models\Product;

//testar nova venda
it('cant_store_new_sale', function () {
    $produtcs = Product::factory()->count(3)->create();
    $saleData = [
        'products' => [
            ['id' => $produtcs[0]->id, 'quantity' => 1],
            ['id' => $produtcs[1]->id, 'quantity' => 1],
        ],
    ];

    $response = $this->postJson('/api/sales', $saleData);
    $response->assertStatus(201);
    $this->assertDatabaseCount('sales', 1);

});


//testar nova venda com produto inexistente
it('cant_store_new_sale_with_nonexistent_product', function () {
    $saleData = [
        'products' => [
            ['id' => 999, 'quantity' => 1],
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


