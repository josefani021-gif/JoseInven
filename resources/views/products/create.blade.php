@extends('layouts.app')

@section('title', 'Tambah Produk')

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

        <h2 class="text-3xl font-bold mb-6 text-black"><x-icon name="plus" class="inline w-6 h-6 mr-2"/>Tambah Produk Baru</h2>

        <div class="glass-card">

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="text-sm font-semibold mb-1 block">Nama Produk *</label>
                        <input type="text" name="name" class="glass-input" value="{{ old('name') }}" required>
                    </div>

                    <div>
                        <label class="text-sm font-semibold mb-1 block">SKU *</label>
                        <input type="text" name="sku" class="glass-input" value="{{ old('sku') }}" required>
                    </div>

                    <div>
                        <label class="text-sm font-semibold mb-1 block">Kategori *</label>
                        <select name="category_id" class="glass-input" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-semibold mb-1 block">Harga *</label>
                        <input type="number" name="price" class="glass-input" value="{{ old('price') }}" required>
                    </div>

                    <div>
                        <label class="text-sm font-semibold mb-1 block">Jumlah *</label>
                        <input type="number" name="quantity" class="glass-input" value="{{ old('quantity', 0) }}" required>
                    </div>

                    <div>
                        <label class="text-sm font-semibold mb-1 block">Stok Minimum *</label>
                        <input type="number" name="minimum_stock" class="glass-input"
                            value="{{ old('minimum_stock', 10) }}" required>
                    </div>

                </div>

                <div class="mt-4">
                    <label class="text-sm font-semibold mb-1 block">Deskripsi</label>
                    <textarea name="description" rows="4" class="glass-input">{{ old('description') }}</textarea>
                </div>

                <div class="flex space-x-3 mt-6">
                    <button class="block glass-menu-item text-black">Buat Produk</button>
                    <a href="{{ route('products.index') }}" class="block glass-menu-item text-black">Batal</a>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection
