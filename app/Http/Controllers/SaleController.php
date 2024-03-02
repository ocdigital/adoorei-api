<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Http\Resources\SaleResource;
use App\Services\SaleCancellationService;

class SaleController extends Controller
{

    public function __construct(private SaleCancellationService $saleCancellationService)
    {}
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
    public function store(StoreSaleRequest $request)
    {
        try{
            $sale = Sale::create();

            foreach ($request->products as $product) {
                $sale->products()->attach($product['id'], ['amount' => $product['amount']]);
            }

            return response()->json($sale, 201);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error', $e], 500);
        }
    }


    public function cancel(Sale $sale)
    {
        try {
            $this->saleCancellationService->cancelSale($sale);
            return response()->json($sale);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 402);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
