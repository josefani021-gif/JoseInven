@extends('layouts.app')

@section('title', 'Daftar - Sistem Inventory')

@section('content')

<style>
    /* Keep same styles as login (copied for isolation) */
    /* Warna utama disesuaikan dengan contoh (turquoise/tosca) */
    :root { --c1: #40E0D0; --c5: #13B9A6; }
    body.auth-page { background: linear-gradient(135deg,#f8fafc 0%,#f1f5f9 25%,#e2e8f0 50%,#f1f5f9 75%,#f8fafc 100%); min-height:100vh; }
    .glass-card{background:linear-gradient(135deg,rgba(255,255,255,.92),rgba(255,255,255,.96));border-radius:24px;backdrop-filter:blur(25px);box-shadow:0 25px 50px rgba(0,0,0,.08);}
    .glass-input{background:rgba(255,255,255,.95);border:1.5px solid rgba(226,232,240,.8);border-radius:14px;padding:1rem 1.25rem}
    .glass-btn{background:linear-gradient(135deg,var(--c1),var(--c5));color:white;padding:1rem 1.5rem;border-radius:14px}
    .password-toggle{position:absolute;right:1rem;top:50%;transform:translateY(-50%);background:transparent;border:none}
</style>

<div class="min-h-screen flex items-center justify-center p-6 auth-page">
    <div class="glass-card p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background:linear-gradient(135deg,#40E0D0 0%,#13B9A6 100%);color:#fff;box-shadow:0 8px 20px rgba(19,185,166,.18);margin:0 auto 1rem">
                <x-icon name="box" class="w-8 h-8 text-white" />
            </div>
            <h1 class="text-2xl font-bold">Buat Akun</h1>
            <p class="text-gray-600">Daftarkan akun baru untuk mengakses sistem inventory</p>
        </div>

        @if ($errors->any())
            <div class="glass-alert px-4 py-3 rounded-lg mb-6">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full glass-input">
                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full glass-input">
                @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <input id="password" name="password" type="password" required class="w-full glass-input pr-12">
                    <button type="button" onclick="togglePasswordReg()" class="password-toggle" aria-label="Toggle password visibility"><x-icon name="eye" class="w-5 h-5 text-gray-700"/></button>
                </div>
                @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full glass-input">
            </div>

            <button type="submit" class="w-full glass-btn">Daftar</button>
        </form>

        <div class="text-center mt-4 text-sm text-gray-600">Sudah punya akun? <a href="{{ route('login') }}" class="font-medium" style="color:#0f766e">Masuk</a></div>
    </div>
</div>

<script>
    function togglePasswordReg(){ const p = document.getElementById('password'); if(p.type==='password'){p.type='text'}else{p.type='password'} }
    document.addEventListener('DOMContentLoaded', function(){ const el = document.getElementById('name'); if(el) el.focus(); });
</script>

@endsection
