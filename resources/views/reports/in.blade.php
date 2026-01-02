@extends('layouts.app')

@section('title', 'Laporan Stok Masuk')

@section('content')
<div class="glass-card p-6 rounded-2xl">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold text-black"><x-icon name="download" class="inline-block mr-2 w-6 h-6"/>Laporan Stok Masuk</h2>
        <div class="flex items-center space-x-2">
            <form method="GET" class="flex items-center space-x-2">
                <input type="date" name="from" value="{{ request('from') }}" class="border px-2 py-1 bg-transparent text-black">
                <input type="date" name="to" value="{{ request('to') }}" class="border px-2 py-1 bg-transparent text-black">
                <button class="btn-blue text-black">Filter</button>
            </form>
            <a href="{{ route('reports.in') }}" class="btn-cream text-black">Reset</a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm glass-table">
            <thead class="bg-transparent">
                <tr>
                    <th class="px-4 py-2 text-left text-black">Tanggal</th>
                    <th class="px-4 py-2 text-left text-black">Produk</th>
                    <th class="px-4 py-2 text-left text-black">Jumlah</th>
                    <th class="px-4 py-2 text-left text-black">Referensi</th>
                    <th class="px-4 py-2 text-left text-black">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $m)
                    <tr class="border-t border-black/10">
                        <td class="px-4 py-2 text-black">{{ $m->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }} WIB</td>
                        <td class="px-4 py-2 text-black">{{ $m->product->name ?? '-' }}</td>
                        <td class="px-4 py-2"><span class="text-black font-bold">{{ $m->quantity }}</span></td>
                        <td class="px-4 py-2 text-black">{{ $m->reference ?? '-' }}</td>
                        <td class="px-4 py-2 text-black">{{ $m->notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-black">Tidak ada data untuk periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 text-black">
        {{ $movements->links() }}
    </div>
</div>
@endsection
