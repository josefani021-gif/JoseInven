@extends('layouts.app')

@section('title', 'Riwayat Stok Masuk')

@section('content')

<style>
    .glass-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(0,0,0,0.15);
        box-shadow: 0 10px 30px rgba(0,255,255,0.08), inset 0 1px 0 rgba(255,255,255,0.03);
        backdrop-filter: blur(14px) saturate(140%);
        border-radius: 1rem;
        padding: 1.25rem;
    }
</style>

<div class="min-h-screen bg-black text-black py-10">
    <div class="max-w-7xl mx-auto">
        <div class="glass-card rounded-2xl">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-black"><x-icon name="download" class="inline-block mr-2 w-6 h-6"/>Riwayat Stok Masuk</h2>
                <a href="{{ route('instock.create') }}" class="block glass-menu-item text-black">Catat Stok Masuk</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm glass-table">
                    <thead class="bg-transparent">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Referensi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Catatan</th>
                            @if(auth()->user() && auth()->user()->role === 'admin')
                                <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $m)
                            <tr class="border-t border-black/10">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $m->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $m->product->name ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $m->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $m->reference ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $m->notes ?? '-' }}</td>
                                @if(auth()->user() && auth()->user()->role === 'admin')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                        <form action="{{ route('instock.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat stok masuk ini? Perubahan stok akan dikembalikan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 text-xs rounded bg-red-600 text-white">Hapus</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-black">Belum ada riwayat stok masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-black">
                {{ $movements->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
