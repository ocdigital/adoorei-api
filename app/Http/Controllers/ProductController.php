<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Listar produtos
     */
    public function index(Product $product)
    {
        return response()->json($product->all());
    }

}
