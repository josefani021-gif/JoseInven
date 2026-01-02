@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="glass-card p-6 rounded-2xl">
    <div class="flex items-center justify-between mb-4">
    <h2 class="text-2xl font-bold text-black"><x-icon name="chart" class="inline-block mr-2 w-6 h-6"/>Laporan Inventory</h2>
        <div class="flex items-center gap-2">
            <a href="{{ route('reports.export') }}" class="block glass-menu-item text-black">Export CSV</a>
            <a href="{{ route('reports.export', ['format' => 'pdf']) }}" class="block glass-menu-item text-black">Export PDF</a>
            <a href="{{ route('reports.in') }}" class="block glass-menu-item text-black">Laporan Stok Masuk</a>
            <a href="{{ route('reports.out') }}" class="block glass-menu-item text-black">Laporan Stok Keluar</a>
        </div>
    </div>

    <div class="mb-6">
        <h3 class="font-semibold text-black">Total Nilai Inventori</h3>
        <p class="text-lg font-bold text-black">Rp {{ number_format($totalValue ?? 0, 0, ',', '.') }}</p>
    </div>

    <div>
        <h3 class="font-semibold mb-2 text-black">Nilai per Kategori</h3>
        <table class="w-full text-sm glass-table">
            <thead class="bg-transparent">
                <tr>
                    <th class="px-4 py-2 text-left text-slate-300">Kategori</th>
                    <th class="px-4 py-2 text-left text-slate-300">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($byCategory as $row)
                        <tr class="border-t border-black/10">
                        <td class="px-4 py-2 text-black">{{ $row->category->name ?? 'Unknown' }}</td>
                        <td class="px-4 py-2 text-black">Rp {{ number_format($row->value ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
