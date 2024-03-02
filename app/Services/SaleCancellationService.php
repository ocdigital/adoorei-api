<?php

namespace App\Services;

use App\Models\Sale;

class SaleCancellationService
{
    /**
     * Cancela uma venda
     *
     * @param Sale $sale
     * @return Sale
     */
    public function cancelSale(Sale $sale): Sale
    {
        if (!$sale) {
            return response()->json(['error' => 'Sale not found'], 404);
        }

        try {
            $sale->status = 'canceled';
            $sale->save();
            return $sale;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error to cancel sale'], 500);
        }

    }
}
