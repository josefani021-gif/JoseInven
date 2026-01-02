@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-3xl font-bold mb-6 text-black-100 flex items-center gap-3"> <x-icon name="folder" class="text-3xl inline-block"/> Tambah Kategori Baru</h2>

    <form action="{{ route('categories.store') }}" method="POST" class="glass-card p-6 rounded-2xl">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold mb-2 text-black-200">Nama Kategori *</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2 bg-transparent text-black-100 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
            @error('name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold mb-2 text-black-200">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="w-full border rounded px-3 py-2 bg-transparent text-black-100">{{ old('description') }}</textarea>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="block glass-menu-item text-black">Buat Kategori</button>
            <a href="{{ route('categories.index') }}" class="block glass-menu-item text-black">Batal</a>
        </div>
    </form>
</div>
@endsection
