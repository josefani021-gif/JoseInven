<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InStockController extends Controller
{
    public function create()
    {
        $products = Product::all();
        return view('instock.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $product = Product::find($validated['product_id']);
        $product->increment('quantity', $validated['quantity']);

        StockMovement::create([
            'product_id' => $validated['product_id'],
            'type' => 'in',
            'quantity' => $validated['quantity'],
            'reference' => $validated['reference'] ?? 'IN',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('instock.success')->with('success', 'Stok berhasil ditambahkan');
    }

    public function success()
    {
        return view('instock.success');
    }

    public function history(Request $request)
    {
        $movements = StockMovement::with('product')
            ->where('type', 'in')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('instock.history', compact('movements'));
    }

    /**
     * Hapus satu riwayat stok masuk (admin only).
     * Saat menghapus, akan mencoba mengembalikan perubahan kuantitas pada produk.
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $movement = StockMovement::findOrFail($id);

        if ($movement->type !== 'in') {
            return redirect()->back()->with('error', 'Jenis riwayat tidak cocok untuk dihapus pada endpoint ini.');
        }

        DB::transaction(function () use ($movement) {
            $product = $movement->product;
            if ($product) {
                // Jangan biarkan stok menjadi negatif. Kurangi sebanyak yang tersedia atau sebanyak movement->quantity.
                $decrement = min($movement->quantity, $product->quantity);
                if ($decrement > 0) {
                    $product->decrement('quantity', $decrement);
                }
            }

            $movement->delete();
        });

        return redirect()->back()->with('success', 'Riwayat stok masuk berhasil dihapus.');
    }
}
