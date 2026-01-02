@extends('layouts.app')

@section('title', 'Produk')

@section('content')

<style>
    .glass-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.15);
        box-shadow: 0 10px 30px rgba(0,255,255,0.08), inset 0 1px 0 rgba(255,255,255,0.03);
        backdrop-filter: blur(14px) saturate(140%);
        -webkit-backdrop-filter: blur(14px) saturate(140%);
        border-radius: 1rem;
        position: relative;
        overflow: hidden;
    }
    .glass-card::before {
        content: '';
        position: absolute;
        top: -30%; left: -20%;
        width: 160%; height: 60%;
        background: linear-gradient(90deg, rgba(224,255,255,0.18), rgba(0,255,255,0.04));
        transform: rotate(-25deg);
        filter: blur(16px);
        opacity: 0.9;
        pointer-events:none;
    }
    .glass-badge {
        padding: 4px 10px;
        border-radius: 8px;
        font-size: .75rem;
        font-weight: 600;
    }
</style>

<div class="min-h-screen bg-black text-black">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-black-300"><x-icon name="box" class="inline w-6 h-6 mr-2 text-black-300"/>Produk</h2>

        @if(auth()->user() && auth()->user()->role === 'admin')
            <a href="{{ route('products.create') }}"
               class="block glass-menu-item text-black">
                Tambah Produk
            </a>
        @endif
    </div>

    {{-- Table Card --}}
    <div class="glass-card p-6 rounded-2xl">

        @if ($products->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm glass-table">
                    <thead>
                        <tr class="border-b border-white/10 text-cyan-200">
                            <th class="px-4 py-3 text-left">SKU</th>
                            <th class="px-4 py-3 text-left">Barcode</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Kategori</th>
                            <th class="px-4 py-3 text-left">Harga</th>
                            <th class="px-4 py-3 text-left">Stok</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-t border-white/5 hover:bg-white/5 transition">
                                <td class="px-4 py-3 font-mono">{{ $product->sku }}</td>

                                <td class="px-4 py-3">
                                    <button class="show-barcode text-cyan-300 hover:text-cyan-200 text-xl"
                                            data-sku="{{ $product->sku }}">
                                        <x-icon name="eye" class="w-5 h-5" />
                                    </button>
                                </td>

                                <td class="px-4 py-3">{{ $product->name }}</td>
                                <td class="px-4 py-3">{{ $product->category->name }}</td>

                                <td class="px-4 py-3">
                                    Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3">{{ $product->quantity }}</td>

                                <td class="px-4 py-3">
                                    @if ($product->quantity == 0)
                                        <span class="glass-badge bg-red-400/50 text-black-300">Habis</span>
                                    @elseif ($product->quantity < $product->minimum_stock)
                                        <span class="glass-badge bg-yellow-400/50 text-black-300">Stok Rendah</span>
                                    @else
                                        <span class="glass-badge bg-green-400/50 text-black-300">Tersedia</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 space-x-3">
                                    <a href="{{ route('products.show', $product) }}"
                                       class="glass-badge bg-green-400/50 text-black-200">
                                        Lihat
                                    </a>

                                    @if(auth()->user() && auth()->user()->role === 'admin')
                                        <a href="{{ route('products.edit', $product) }}"
                                           class="glass-badge bg-blue-400/50 text-black-200">
                                            Ubah
                                        </a>

                                        <form action="{{ route('products.destroy', $product) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Yakin hapus produk?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="glass-badge bg-red-400/50 text-black-200">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>

        @else
            <p class="text-center text-slate-400 py-6">
                Tidak ada produk.
                @if(auth()->user() && auth()->user()->role === 'admin')
                    <a href="{{ route('products.create') }}" class="block glass-menu-item inline-flex items-center gap-2">
                        Tambah Produk <x-icon name="plus" class="w-4 h-4" />
                    </a>
                @endif
            </p>
        @endif

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script>

    function ensureBarcodeModal() {
        if (document.getElementById('barcode-modal')) return;

        const modal = document.createElement('div');
        modal.id = 'barcode-modal';
        modal.className =
            "fixed inset-0 bg-black/60 flex items-center justify-center p-4 hidden";

        modal.innerHTML = `
            <div class="glass-card p-6 rounded-xl max-w-md w-full relative">
                <button id="barcode-modal-close"
                        class="absolute top-2 right-2 bg-white/10 px-2 py-1 rounded hover:bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>

                <h3 class="text-lg font-semibold text-cyan-300 mb-3">Barcode Produk</h3>
                <div id="barcode-modal-container" class="flex justify-center">
                    <svg id="barcode-modal-svg"></svg>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        modal.querySelector("#barcode-modal-close")
            .addEventListener("click", () => modal.classList.add("hidden"));
    }

    document.addEventListener("DOMContentLoaded", () => {
        ensureBarcodeModal();

        document.body.addEventListener("click", (e) => {
            const btn = e.target.closest(".show-barcode");
            if (!btn) return;

            const sku = btn.dataset.sku;
            const modal = document.getElementById("barcode-modal");
            const svg = document.getElementById("barcode-modal-svg");

            while (svg.firstChild) svg.removeChild(svg.firstChild);

            JsBarcode(svg, sku, {
                format: "CODE128",
                displayValue: true,
                height: 80
            });

            modal.classList.remove("hidden");
        });
    });

</script>
@endpush

@endsection
