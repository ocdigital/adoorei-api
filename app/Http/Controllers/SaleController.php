<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Http\Resources\SaleResource;
use App\Services\SaleCancellationService;
use App\Services\SaleProductService;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{

    public function __construct(
        private SaleCancellationService $saleCancellationService,
        private SaleProductService $saleProductService
    )
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
            DB::beginTransaction();
            $sale = Sale::create();

            foreach ($request->products as $product) {
                $sale->products()->attach($product['id'], ['amount' => $product['amount']]);
            }

            DB::commit();
            return response()->json($sale, 201);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error when trying to create'], 500);
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
            $this->validateProducts($request->products);

            $this->attachProductsToSale($sale, $request->products);

            return response()->json($sale, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Product(s) not found'], 422);
        }
    }

    private function validateProducts($products)
    {
        $this->saleProductService->validateProducts($products);
    }

    private function attachProductsToSale(Sale $sale, $products)
    {
        foreach ($products as $product) {
            $sale->products()->attach($product['id'], ['amount' => $product['amount']]);
        }
    }


}
