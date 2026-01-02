@extends('layouts.app')

@section('title', 'Kategori')

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
    .glass-card::before{
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
    .glass-glow {
        box-shadow: 0 8px 30px rgba(0,255,255,0.14), 0 2px 8px rgba(0,0,0,0.08) !important;
    }
    .glass-pill { background: rgba(255,255,255,0.06); border-radius: 9999px; padding: .25rem .6rem; }
    .glass-tag { background: rgba(0,255,255,0.08); color: #00343a; padding: .15rem .5rem; border-radius: .5rem; font-size: .75rem; }
</style>
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-black-100 flex items-center gap-3"> <x-icon name="folder" class="text-3xl text-black inline-block"/> Kategori</h2>
    <a href="{{ route('categories.create') }}" class="block glass-menu-item text-black">Tambah Kategori</a>
</div>
<div class="glass-card p-6 rounded-2xl">
    @if ($categories->count() > 0)
        <table class="w-full glass-table">
            <thead class="bg-transparent">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black-300">Nama</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black-300">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black-300">Produk</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-t border-white/5">
                        <td class="px-6 py-4 text-black-100">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-black-300">{{ Str::limit($category->description, 50) }}</td>
                        <td class="px-6 py-4 text-black-100">{{ $category->products_count }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('categories.edit', $category) }}" class="glass-badge bg-green-400/50 text-black-300">Ubah</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apa Anda yakin?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="glass-badge bg-red-400/50 text-black-200">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="p-6 text-center text-slate-400">
            Tidak ada kategori. <a href="{{ route('categories.create') }}" class="text-cyan-300 hover:text-cyan-200">Buat baru</a>
        </div>
    @endif
</div>
@endsection
