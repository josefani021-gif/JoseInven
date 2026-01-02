@extends('layouts.app')

@section('title', $product->name)

@section('content')

<div class="min-h-screen bg-black text-black py-10 px-4">

    <div class="max-w-5xl mx-auto">

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-4xl font-extrabold text-black drop-shadow">
                {{ $product->name }}
            </h2>

            <div class="space-x-3">
                <a href="{{ route('products.index') }}"
                    class="block glass-menu-item text-black inline-flex items-center gap-2">
                    <x-icon name="arrow-left" class="w-4 h-4"/> Kembali
                </a>
            </div>
        </div>

        <style>
            .glass-card {
                background: rgba(255,255,255,0.06);
                border: 1px solid rgba(0, 0, 0, 1);
                box-shadow: 0 10px 30px rgba(0,255,255,0.08);
                backdrop-filter: blur(14px);
                border-radius: 1rem;
                padding: 2rem;
            }
        </style>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="glass-card">
                <h3 class="text-xl font-bold mb-4 text-black-200"><x-icon name="receipt" class="inline w-5 h-5 mr-2"/>Informasi Produk</h3>

                <div class="space-y-3">

                    <div>
                        <span class="font-semibold text-black-200">SKU:</span>
                        <span class="font-mono text-lg">{{ $product->sku }}</span>
                    </div>

                    <div>
                        <span class="font-semibold text-black-200">Kategori:</span>
                        <span>{{ $product->category->name }}</span>
                    </div>

                    <div>
                        <span class="font-semibold text-black-200">Harga:</span>
                        <span class="text-xl font-extrabold text-black-300">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <div>
                        <span class="font-semibold text-black-200">Deskripsi:</span>
                        <p>{{ $product->description ?? '-' }}</p>
                    </div>

                </div>
            </div>

            <div class="glass-card">
                <h3 class="text-xl font-bold mb-4 text-black-200"><x-icon name="box" class="inline w-5 h-5 mr-2"/>Informasi Stok</h3>

                <div class="space-y-3">

                    <div>
                        <span class="font-semibold text-black-200">Barcode:</span>
                        <button type="button" class="show-barcode-single text-3xl"
                            data-sku="{{ $product->sku }}">
                            <x-icon name="eye" class="w-6 h-6" />
                        </button>
                    </div>

                    <div>
                        <span class="font-semibold text-black-200">Stok Saat Ini:</span>
                        <span class="text-3xl font-bold text-black">
                            {{ $product->quantity }}
                        </span>
                    </div>

                    <div>
                        <span class="font-semibold text-black-200">Level Minimum:</span>
                        <span>{{ $product->minimum_stock }}</span>
                    </div>

                    <div>
                        <span class="font-semibold text-black-200">Status:</span>

                        @if ($product->quantity == 0)
                            <span class="px-3 py-1 rounded-xl bg-red-500/50 text-black-300 font-bold">
                                Habis
                            </span>
                        @elseif ($product->quantity < $product->minimum_stock)
                            <span class="px-3 py-1 rounded-xl bg-yellow-400/50 text-black-300 font-bold">
                                Stok Rendah
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-xl bg-green-400/50 text-black-300 font-bold">
                                Tersedia
                            </span>
                        @endif
                    </div>

                    <div>
                        <span class="font-semibold text-black-200">Nilai Total:</span>
                        <span class="text-xl font-extrabold text-black-300">
                            Rp {{ number_format($product->price * $product->quantity, 0, ',', '.') }}
                        </span>
                    </div>

                </div>
            </div>

        </div>

        {{-- RIWAYAT STOK --}}
        @if ($product->stockMovements->count() > 0)

            <div class="glass-card mt-10">
                <h3 class="text-2xl font-bold text-black mb-4"><x-icon name="chart" class="inline w-5 h-5 mr-2"/>Riwayat Pergerakan Stok</h3>

                <table class="w-full text-left text-black text-sm glass-table">
                    <thead class="bg-white/10">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Jenis</th>
                            <th class="px-4 py-3">Jumlah</th>
                            <th class="px-4 py-3">Referensi</th>
                            <th class="px-4 py-3">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->stockMovements->sortByDesc('created_at') as $movement)
                            <tr class="border-t border-white/10 hover:bg-white/10">
                                <td class="px-4 py-3">
                                    {{ $movement->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }} WIB
                                </td>

                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-lg text-xs font-semibold
                                        {{ $movement->type === 'in'
                                            ? 'bg-green-400/50 text-black-300'
                                            : 'bg-red-400/50 text-black-300' }}">
                                        {{ $movement->type === 'in' ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">{{ $movement->quantity }}</td>
                                <td class="px-4 py-3">{{ $movement->reference ?? '-' }}</td>
                                <td class="px-4 py-3">{{ Str::limit($movement->notes ?? '-', 30) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        @endif

    </div>
</div>

@endsection
