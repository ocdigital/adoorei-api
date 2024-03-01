<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Http\Resources\SaleResource;

class SaleController extends Controller
{

    /**
     * Listar vendas
     */
    public function index()
    {
        $sales = Sale::with('products')->get();
        return SaleResource::collection($sales);
    }

    /**
     * Exibir uma venda
     */
    public function show(Sale $sale)
    {
        return new SaleResource($sale);
    }

    /**
     * Nova venda
     */
    public function store(Request $request)
    {

        if (!$request->products) {
            return response()->json(['error' => 'Products is required'], 422);
        }

        //validar se existe os produtos antes
        foreach ($request->products as $product) {
            if (!Product::find($product['id'])) {
                return response()->json(['error' => 'Product not found'], 422);
            }
        }

        $sale = Sale::create();

        foreach ($request->products as $product) {
            $sale->products()->attach($product['id'], ['amount' => $product['amount']]);
        }

        return response()->json($sale, 201);
    }


    public function cancel(Sale $sale)
    {
        //garanta que a venda exista e cancela
        if (!$sale) {
            return response()->json(['error' => 'Sale not found'], 404);
        }

        try {
            $sale->status = 'canceled';
            $sale->save();
            return response()->json($sale);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Error to cancel sale',$e], 500);
        }

    }

    /**
     * Cadastrar novas produtos a uma venda
     */
    public function addProductToSale(Request $request, Sale $sale)
    {
        try {
            // Verifica se a solicitação contém a chave 'products'
            if (!$request->has('products') || empty($request->products)) {
                return response()->json(['error' => 'Products is required'], 422);
            }

            // Obtém os IDs dos produtos a serem adicionados
            $productIds = collect($request->products)->pluck('id')->toArray();

            // Valida se os produtos existem antes de adicioná-los
            $existingProducts = Product::whereIn('id', $productIds)->get();
            $missingProductIds = array_diff($productIds, $existingProducts->pluck('id')->toArray());

            if (!empty($missingProductIds)) {
                return response()->json(['error' => 'Product(s) not found'], 422);
            }

            // Adiciona os produtos à venda
            foreach ($request->products as $product) {
                $sale->products()->attach($product['id'], ['amount' => $product['amount']]);
            }

            return response()->json($sale,201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error', $e], 500);
        }
    }


}
