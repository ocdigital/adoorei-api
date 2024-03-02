<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Sale;


class SaleProductService
{
    //vericiar no banco se a venda existe
    public function validateSale($sale): void
    {
        if (!$sale) {
            throw new \Exception('Sale not found');
        }
    }


    public function validateProducts($products): void
    {
        // Obtém os IDs dos produtos a serem adicionados
        $productIds = collect($products)->pluck('id')->toArray();

        // Valida se os produtos existem antes de adicioná-los
        $existingProducts = Product::whereIn('id', $productIds)->get();
        $missingProductIds = array_diff($productIds, $existingProducts->pluck('id')->toArray());

        if (!empty($missingProductIds)) {
            throw new \Exception('Product(s) not found');
        }
    }


}
