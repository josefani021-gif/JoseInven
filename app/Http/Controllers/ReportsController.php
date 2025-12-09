<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        $totalValue = Product::sum(DB::raw('price * quantity'));
        $byCategory = Product::select('category_id', DB::raw('sum(price * quantity) as value'))
            ->groupBy('category_id')
            ->with('category')
            ->get();

        return view('reports.index', compact('totalValue', 'byCategory'));
    }

    /**
     * Laporan stok masuk
     */
    public function in(Request $request)
    {
        $query = StockMovement::with('product')->where('type', 'in')->orderBy('created_at', 'desc');

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->input('to'));
        }

        $movements = $query->paginate(30)->withQueryString();

        return view('reports.in', compact('movements'));
    }

    /**
     * Laporan stok keluar
     */
    public function out(Request $request)
    {
        $query = StockMovement::with('product')->where('type', 'out')->orderBy('created_at', 'desc');

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->input('to'));
        }

        $movements = $query->paginate(30)->withQueryString();

        return view('reports.out', compact('movements'));
    }

    public function export(Request $request)
    {
        $totalValue = Product::sum(DB::raw('price * quantity'));
        $byCategory = Product::select('category_id', DB::raw('sum(price * quantity) as value'))
            ->groupBy('category_id')
            ->with('category')
            ->get();

        $filename = 'inventory_report_' . date('Ymd_His') . '.csv';

        $callback = function () use ($byCategory, $totalValue) {
            $out = fopen('php://output', 'w');

            // Header
            fputcsv($out, ['Kategori', 'Nilai']);

            // Rows
            foreach ($byCategory as $row) {
                $category = $row->category->name ?? 'Unknown';
                fputcsv($out, [$category, number_format($row->value, 2, '.', '')]);
            }

            // Empty row then total
            fputcsv($out, []);
            fputcsv($out, ['Total', number_format($totalValue, 2, '.', '')]);

            fclose($out);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
