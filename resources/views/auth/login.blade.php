@extends('layouts.app')

@section('title', 'Masuk - Sistem Inventory')

@section('content')

<style>
    /* Use global palette from layout; local overrides removed to inherit tosca */

    /* Background Gradient - Modern & Aesthetic */
    body.auth-page {
        background: linear-gradient(135deg,
            #f8fafc 0%,
            #f1f5f9 25%,
            #e2e8f0 50%,
            #f1f5f9 75%,
            #f8fafc 100%);
        min-height: 100vh;
        background-attachment: fixed;
        background-size: 400% 400%;
        animation: gradientShift 20s ease infinite;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Glass Card Effect */
    .glass-card {
        background: linear-gradient(135deg,
            rgba(255, 255, 255, 0.92) 0%,
            rgba(255, 255, 255, 0.96) 100%);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow:
            0 25px 50px rgba(0, 0, 0, 0.08),
            0 15px 30px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(25px);
        border-radius: 24px;
        position: relative;
        overflow: hidden;
    }

    .glass-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg,
            transparent 0%,
            rgba(99, 102, 241, 0.04) 50%,
            transparent 100%);
        pointer-events: none;
    }

    .glass-input {
        background: rgba(255, 255, 255, 0.95);
        border: 1.5px solid rgba(226, 232, 240, 0.8);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        color: #1e293b;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    .glass-input:focus {
        outline: none;
        border-color: var(--c1);
        box-shadow: 0 0 0 6px rgba(64, 224, 208, 0.12);
        transform: translateY(-1px);
    }

    .glass-btn {
        background: linear-gradient(135deg, var(--c1), var(--c4));
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 14px;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(19, 185, 166, 0.22);
    }

    .glass-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 35px rgba(19, 185, 166, 0.28); }

    .glass-alert { background: linear-gradient(135deg, rgba(239, 68, 68, 0.95), rgba(220, 38, 38, 0.95)); border: 1px solid rgba(239, 68, 68, 0.3); color: white !important; border-radius: 14px; }

    .logo-animation { animation: float 6s ease-in-out infinite; }

    @keyframes float { 0%,100%{transform:translateY(0) rotate(0deg);}25%{transform:translateY(-10px) rotate(5deg);}75%{transform:translateY(10px) rotate(-5deg);} }

    .password-toggle { position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: transparent; border: none; color: #94a3b8; cursor: pointer; }

    @media (max-width: 640px) { .glass-card { margin: 1rem; padding: 1.5rem !important; } }
</style>

<div class="min-h-screen flex items-center justify-center p-6 auth-page">
    <div class="glass-card p-8 w-full max-w-md">
        <!-- Logo Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-full flex items-center justify-center text-white text-2xl shadow-lg mx-auto mb-4 logo-animation" style="background:linear-gradient(135deg,var(--c1),var(--c4));">
                <x-icon name="box" class="w-8 h-8 text-white" />
            </div>
            <h1 class="text-3xl font-bold bg-clip-text text-transparent mb-2" style="background:linear-gradient(90deg,var(--c1),var(--c4));">
                Sistem Inventory
            </h1>
            <p class="text-gray-600">Masuk ke sistem inventory</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="glass-alert px-4 py-3 rounded-lg mb-6">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" class="w-full glass-input focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="w-full glass-input focus:ring-2 focus:ring-blue-500 pr-12" placeholder="••••••••" required>
                    <button type="button" onclick="togglePassword()" class="password-toggle" aria-label="Toggle password visibility"><x-icon name="eye" class="w-5 h-5 text-gray-700"/></button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full glass-btn">Masuk</button>
        </form>

        <div class="text-center mt-4 text-sm text-gray-600">Belum punya akun? <a href="{{ route('register') }}" class="font-medium" style="color:var(--c4)">Daftar</a></div>
    </div>
</div>

<script>
    function togglePassword() { const passwordInput = document.getElementById('password'); if (passwordInput.type === 'password') { passwordInput.type = 'text'; } else { passwordInput.type = 'password'; } }
    document.addEventListener('DOMContentLoaded', function() { const el = document.getElementById('email'); if(el) el.focus(); });
</script>

@endsection
