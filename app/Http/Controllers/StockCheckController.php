<?php

namespace App\Http\Controllers;

use App\Models\Product;

class StockCheckController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('stock.check', compact('products'));
    }
}
