@extends('layouts.app')

@section('title', 'Tambah Stok (Masuk)')

@section('content')

<style>
    .glass-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(0,0,0,0.15);
        box-shadow: 0 10px 30px rgba(0,255,255,0.08), inset 0 1px 0 rgba(255,255,255,0.03);
        backdrop-filter: blur(14px) saturate(140%);
        border-radius: 1rem;
        padding: 2rem;
    }
    .glass-input {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(0,0,0,0.15);
        padding: .6rem .75rem;
        border-radius: .6rem;
        width: 100%;
        color: black;
    }
    .glass-input:focus {
        border-color: rgba(0,0,0,0.4);
        outline: none;
        box-shadow: 0 0 6px rgba(0,0,0,0.08);
    }
    .glass-btn {
        background: rgba(0,255,255,0.15);
        border: 1px solid rgba(0,255,255,0.3);
        padding: .6rem 1.4rem;
        border-radius: .6rem;
        color: black;
        transition: .2s;
    }
    .glass-btn:hover {
        background: rgba(0,255,255,0.3);
    }
    .glass-danger {
        background: rgba(255,0,0,0.15);
        border: 1px solid rgba(255,0,0,0.3);
        color: black;
    }
    .glass-danger:hover {
        background: rgba(255,0,0,0.3);
    }
</style>

<div class="min-h-screen bg-black text-black py-10">
    <div class="max-w-3xl mx-auto">

        <h2 class="text-3xl font-bold mb-6 text-black"><x-icon name="download" class="inline-block mr-2 w-6 h-6"/>Tambah Stok (Masuk)</h2>

        <div class="glass-card">

            <form action="{{ route('instock.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-4">

                    <div>
                        <label for="product_id" class="text-sm font-semibold mb-1 block">Produk *</label>
                        <select name="product_id" id="product_id" class="glass-input @error('product_id') border-red-500 @enderror" required>
                            <option value="">Pilih produk</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (stok: {{ $product->quantity }})</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="quantity" class="text-sm font-semibold mb-1 block">Jumlah *</label>
                        <input type="number" name="quantity" id="quantity" class="glass-input @error('quantity') border-red-500 @enderror" value="{{ old('quantity', 1) }}" required>
                        @error('quantity')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="reference" class="text-sm font-semibold mb-1 block">Referensi</label>
                        <input type="text" name="reference" id="reference" class="glass-input" value="{{ old('reference') }}">
                    </div>

                    <div>
                        <label for="notes" class="text-sm font-semibold mb-1 block">Catatan</label>
                        <textarea name="notes" id="notes" rows="3" class="glass-input">{{ old('notes') }}</textarea>
                    </div>

                </div>

                <div class="flex space-x-3 mt-6">
                    <button type="submit" class="block glass-menu-item text-black">Tambah Stok</button>
                    <a href="{{ route('dashboard') }}" class="block  glass-menu-item text-black">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
