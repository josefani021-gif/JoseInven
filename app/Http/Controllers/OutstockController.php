<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OutstockController extends Controller
{
    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        return view('outstock.create', compact('products'));
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

        if ($product->quantity < $validated['quantity']) {
            return redirect()->back()->withErrors([
                'quantity' => 'Stok tidak cukup. Stok tersedia: ' . $product->quantity,
            ])->withInput();
        }

        $product->decrement('quantity', $validated['quantity']);

        StockMovement::create([
            'product_id' => $validated['product_id'],
            'type' => 'out',
            'quantity' => $validated['quantity'],
            'reference' => $validated['reference'] ?? 'POS',
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('outstock.success')->with('success', 'Barang berhasil dicatat keluar');
    }

    public function success()
    {
        return view('outstock.success');
    }

    /**
     * Tampilkan riwayat stok keluar untuk cashier
     */
    public function history(Request $request)
    {
        $movements = StockMovement::with('product')
            ->where('type', 'out')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('outstock.history', compact('movements'));
    }

    /**
     * Hapus satu riwayat stok keluar (admin only).
     * Saat menghapus, akan mengembalikan barang ke stok produk.
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $movement = StockMovement::findOrFail($id);

        if ($movement->type !== 'out') {
            return redirect()->back()->with('error', 'Jenis riwayat tidak cocok untuk dihapus pada endpoint ini.');
        }

        DB::transaction(function () use ($movement) {
            $product = $movement->product;
            if ($product) {
                $product->increment('quantity', $movement->quantity);
            }

            $movement->delete();
        });

        return redirect()->back()->with('success', 'Riwayat stok keluar berhasil dihapus.');
    }
}
