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

//consultar uma venda específica
it('cant_show_sale', function () {
    $products = Product::factory(2)->create();
    $saleData = [
        'products' => [
            ['id' => $products[0]->id, 'amount' => 1],
            ['id' => $products[1]->id, 'amount' => 1],
        ],
    ];
    $response = $this->postJson('/api/sales', $saleData);
    $sale = Sale::first();
    $response = $this->getJson('/api/sales/' . $sale->id);
    $response->assertStatus(200);
});

//cancelar uma venda
it('cant_cancel_sale', function () {
    $products = Product::factory(2)->create();
    $saleData = [
        'products' => [
            ['id' => $products[0]->id, 'amount' => 1],
            ['id' => $products[1]->id, 'amount' => 1],
        ],
    ];
    $response = $this->postJson('/api/sales', $saleData);
    $sale = Sale::first();
    $response = $this->putJson('/api/sales/' . $sale->id . '/cancel');
    $response->assertStatus(200);
});

// Cadastrar novos produtos a uma venda
it('cant_add_products_to_sale', function () {
    $products = Product::factory(2)->create();

    // Criar uma nova venda
    $saleData = [
        'products' => [
            ['id' => $products[0]->id, 'amount' => 1],
        ],
    ];
    $response = $this->postJson('/api/sales', $saleData);
    $response->assertStatus(201);

    // Obter a instância da venda criada
    $sale = Sale::first();

    // Adicionar mais produtos à venda usando o endpoint específico
    $additionalProducts = [
        ['id' => $products[1]->id, 'amount' => 2],
        // Adicione outros produtos conforme necessário
    ];

    $response = $this->putJson("/api/sales/{$sale->id}/add-product", ['products' => $additionalProducts]);

    // Verificar se a resposta é 200 OK
    $response->assertStatus(201);
});



