<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ScanController extends Controller
{
    public function index()
    {
        return view('transactions.scan');
    }

    public function searchByCode(Request $request)
    {
        $code = $request->get('code');

        if (!$code) {
            return response()->json(['error' => 'No code provided'], 400);
        }

        // Try to find by SKU first, then by id
        $product = Product::where('sku', $code)->orWhere('id', $code)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json(['product' => $product]);
    }
}
