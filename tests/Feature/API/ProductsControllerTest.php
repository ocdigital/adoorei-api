<?php

it('lists available products', function () {
    $response = $this->getJson('/api/products');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        '*' => ['id', 'name', 'price','description', 'created_at', 'updated_at'],
    ]);
});
