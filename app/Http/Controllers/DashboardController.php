<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\StockMovement;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $lowStockProducts = Product::where('quantity', '<', 'minimum_stock')->get();

        // Ambil 5 entri terbaru stok masuk dan stok keluar
        $recentIn = StockMovement::with('product')
            ->where('type', 'in')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentOut = StockMovement::with('product')
            ->where('type', 'out')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'lowStockProducts' => $lowStockProducts,
            'recentIn' => $recentIn,
            'recentOut' => $recentOut,
        ]);
    }
}
