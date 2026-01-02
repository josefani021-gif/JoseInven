<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Inventory') - Manajemen Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Aesthetic Color Palette - Modern & Clean */
        :root {
            /* Palette updated to turquoise/tosca accent */
            --c1: #40E0D0; /* Turquoise (main) */
            --c2: #f8fafc; /* Soft white */
            --c3: #ec4899; /* Pink */
            --c4: #13B9A6; /* Tosca (accent) */
            --c5: #0f766e; /* Deep tosca */
            --cream: #fef3c7; /* Warm cream */
            --blue: #3b82f6; /* Blue (used sparingly) */
        }

          /* Global color overrides: map common utility classes to turquoise/tosca palette
              This makes hard-coded utility classes across views inherit the new accent. */
          .from-blue-500 { background-image: none !important; background-color: var(--c1) !important; }
          .to-purple-600 { background-image: none !important; background-color: var(--c4) !important; }
          .from-teal-400 { background-image: none !important; background-color: var(--c1) !important; }
          .to-teal-600 { background-image: none !important; background-color: var(--c4) !important; }

          .bg-blue-500 { background-color: var(--c1) !important; }
          .bg-indigo-600 { background-color: var(--c1) !important; }
          .text-indigo-600 { color: var(--c4) !important; }
          .text-blue-600 { color: var(--c4) !important; }
          .text-teal-600 { color: var(--c4) !important; }

          /* badges / pills */
          .bg-green-900\/40 { background: rgba(19,185,166,0.12) !important; color: var(--c5) !important; }
          .bg-red-900\/40 { background: rgba(239,68,68,0.12) !important; color: #b91c1c !important; }

          /* gradient text helpers */
          .bg-gradient-to-r.from-blue-600.to-purple-600 { background: linear-gradient(90deg,var(--c1),var(--c4)) !important; -webkit-background-clip: text; color: transparent; }

          /* override inline gradient utilities used for icons/avatars */
          .logo-gradient { background: linear-gradient(135deg,var(--c1),var(--c4)) !important; }

        /* Background Gradient - Aesthetic & Modern */
        body.bg-black {
            background: linear-gradient(135deg,
                #f8fafc 0%,
                #f1f5f9 25%,
                #e2e8f0 50%,
                #f1f5f9 75%,
                #f8fafc 100%) !important;
            color: #1e293b !important;
            min-height: 100vh;
            background-attachment: fixed;
            background-size: 400% 400%;
            animation: gradientShift 20s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Scrollable Sidebar Styling */
        .scrollable-sidebar {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            flex-shrink: 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 4px;
        }

        .sidebar-footer {
            flex-shrink: 0;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Custom scrollbar untuk sidebar */
        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--c1), var(--c5));
            border-radius: 10px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--c5), var(--c4));
        }

        /* Untuk Firefox */
        .sidebar-nav {
            scrollbar-width: thin;
            scrollbar-color: var(--c1) rgba(255, 255, 255, 0.1);
        }

        /* Accent Colors */
        .accent-cyan{ color: var(--c4) !important; }
        .accent-green{ color: var(--c4) !important; }
        .accent-red{ color: var(--c3) !important; }
        .accent-yellow{ color: #f59e0b !important; }
        .accent-purple{ color: var(--c5) !important; }
        .accent-indigo{ color: var(--c1) !important; }

        /* Glass Table - Modern Aesthetic */
        .glass-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
        }

        .glass-table th,
        .glass-table td {
            border: 1px solid rgba(255, 255, 255, 0.8) !important;
            background-clip: padding-box;
            color: #1e293b !important;
        }

        .glass-table thead th {
            background: linear-gradient(135deg, var(--c1), var(--c5));
            color: white !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
            border-bottom: none !important;
            padding: 1rem;
        }

        .glass-table tbody tr {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(19, 185, 166, 0.08);
        }

        .glass-table td {
            padding: 1rem;
            border-color: rgba(226, 232, 240, 0.5) !important;
        }

        /* Glass Menu Item - Modern & Sleek */
        .glass-menu-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .75rem 1rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: white;
            margin-bottom: 8px;
        }

        .glass-menu-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(19, 185, 166, 0.22);
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--c1);
        }

        .glass-menu-item .icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: 10px;
            font-size: 1.1rem;
            line-height: 1;
            background: linear-gradient(135deg, var(--c1), var(--c5));
            color: white;
        }

        .glass-menu-item .label {
            font-weight: 600;
            font-size: 0.95rem;
        }

        /* Glass Card - Modern Dashboard Cards */
        .glass-card {
            background: linear-gradient(135deg,
                rgba(255, 255, 255, 0.9) 0%,
                rgba(255, 255, 255, 0.95) 100%);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.08),
                0 10px 20px rgba(0, 0, 0, 0.04),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow:
                0 30px 60px rgba(64, 224, 208, 0.14),
                0 15px 30px rgba(0, 0, 0, 0.1);
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
                rgba(64, 224, 208, 0.03) 50%,
                transparent 100%);
            pointer-events: none;
        }

        .glass-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
                transparent 30%,
                rgba(19, 185, 166, 0.05) 50%,
                transparent 70%);
            transform: rotate(25deg);
            animation: shimmer 3s infinite;
            pointer-events: none;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) rotate(25deg); }
            100% { transform: translateX(100%) rotate(25deg); }
        }

        /* Glass Effects */
        .glass-glow {
            box-shadow:
                0 0 40px rgba(64, 224, 208, 0.18),
                0 10px 40px rgba(0, 0, 0, 0.1) !important;
        }

        .glass-pill {
            background: linear-gradient(135deg, var(--c1), var(--c5));
            color: white;
            border-radius: 9999px;
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .glass-tag {
            background: linear-gradient(135deg, var(--c4), var(--c1));
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Button Styles */
        .btn-blue {
            background: linear-gradient(135deg, var(--c1), var(--c5));
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(19, 185, 166, 0.22);
            width: 100%;
        }

        .btn-blue:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(19, 185, 166, 0.28);
        }

        .btn-cream {
            background: linear-gradient(135deg, var(--cream), #fbbf24);
            color: #1e293b;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
            width: 100%;
        }

        .btn-cream:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(251, 191, 36, 0.4);
        }

        /* Override Utilities */
        .bg-black { background: transparent !important; }

        .text-black { color: #1e293b !important; }

        .text-white { color: white !important; }

        .border-black { border-color: rgba(30, 41, 59, 0.1) !important; }

        .border-white { border-color: rgba(255, 255, 255, 0.3) !important; }

        .bg-slate-900 {
            background: linear-gradient(135deg,
                rgba(15, 23, 42, 0.95) 0%,
                rgba(30, 41, 59, 0.95) 100%) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .bg-gray-800 {
            background: linear-gradient(135deg,
                rgba(255, 255, 255, 0.95) 0%,
                rgba(248, 250, 252, 0.95) 100%) !important;
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.4);
        }

        /* Sidebar Styling */
        aside {
            background: linear-gradient(135deg,
                rgba(15, 23, 42, 0.98) 0%,
                rgba(30, 41, 59, 0.98) 100%) !important;
            backdrop-filter: blur(30px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 10px 0 40px rgba(0, 0, 0, 0.2);
        }

        aside h1 {
            background: linear-gradient(135deg, #fff, var(--c1));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 1.75rem;
        }

        /* Alert/Notification Styles */
        .bg-red-900\/60 {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.95), rgba(220, 38, 38, 0.95)) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: white !important;
            border-radius: 12px;
        }

        .bg-green-900\/60 {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.95), rgba(21, 128, 61, 0.95)) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: white !important;
            border-radius: 12px;
        }

        /* Main Content Area */
        main.bg-black {
            background: transparent !important;
        }

        /* Custom Scrollbar untuk halaman */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(241, 245, 249, 0.5);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--c1), var(--c5));
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--c5), var(--c3));
        }

        /* User Info Card */
        .text-cyan-300 {
            color: var(--c4) !important;
            font-weight: 500;
            background: rgba(20, 184, 166, 0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 8px;
            display: inline-block;
        }

        /* Active menu item */
        .glass-menu-item.active {
            background: linear-gradient(135deg, var(--c1), var(--c5));
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .glass-menu-item.active .icon {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar-nav {
                padding-right: 2px;
            }

            .sidebar-nav::-webkit-scrollbar {
                width: 4px;
            }
        }
    </style>
</head>
<body class="bg-black text-black">
    <div class="flex min-h-screen">
        <!-- Sidebar dengan Scroll -->
        <aside class="w-64 h-screen fixed left-0 top-0 bg-slate-900 shadow-xl flex flex-col border-r border-white/10 scrollable-sidebar">

            <!-- HEADER - TIDAK SCROLL -->
            <div class="sidebar-header p-6">
                <h1 class="text-2xl font-bold">Sistem Inventory</h1>
                <div class="mt-3">
                        <a href="{{ route('welcome') }}" class="inline-flex items-center gap-2 px-3 py-2 bg-white/10 rounded-lg text-white hover:bg-white/20">
                        <span class="icon"><x-icon name="home" class="w-5 h-5" /></span>
                        <span class="text-sm font-medium">Beranda</span>
                    </a>
                </div>
            </div>

            <!-- NAVIGATION MENU - AREA SCROLL -->
            <div class="sidebar-nav px-6 pb-6">
                @auth
                    <nav class="space-y-2 pt-2">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" class="block glass-menu-item">
                            <span class="icon"><x-icon name="home" class="w-5 h-5" /></span>
                            <span class="label">Dashboard</span>
                        </a>

                        <!-- Admin Menu -->
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('products.index') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="box" class="w-5 h-5" /></span>
                                <span class="label">Produk</span>
                            </a>
                            <a href="{{ route('categories.index') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="folder" class="w-5 h-5" /></span>
                                <span class="label">Kategori</span>
                            </a>
                            <a href="{{ route('outstock.create') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="upload" class="w-5 h-5" /></span>
                                <span class="label">Catat Barang Keluar</span>
                            </a>
                            <a href="{{ route('instock.create') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="download" class="w-5 h-5" /></span>
                                <span class="label">Catat Barang Masuk</span>
                            </a>
                            <a href="{{ route('outstock.history') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="tag" class="w-5 h-5" /></span>
                                <span class="label">Riwayat Keluar</span>
                            </a>
                            <a href="{{ route('instock.history') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="tag" class="w-5 h-5" /></span>
                                <span class="label">Riwayat Masuk</span>
                            </a>
                            <a href="{{ route('reports.index') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="chart" class="w-5 h-5" /></span>
                                <span class="label">Laporan</span>
                            </a>
                            <a href="{{ route('labels.print') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="tag" class="w-5 h-5" /></span>
                                <span class="label">Label</span>
                            </a>
                            <a href="{{ route('users.index') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="users" class="w-5 h-5" /></span>
                                <span class="label">Kelola Akun</span>
                            </a>
                        @endif

                        <!-- Cashier Menu -->
                        @if(auth()->user()->role === 'cashier')
                            <a href="{{ route('products.index') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="box" class="w-5 h-5"/></span>
                                <span class="label">Produk</span>
                            </a>
                            <a href="{{ route('outstock.create') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="upload" class="w-5 h-5"/></span>
                                <span class="label">Catat Barang Keluar</span>
                            </a>
                            <a href="{{ route('outstock.history') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="receipt" class="w-5 h-5"/></span>
                                <span class="label">Riwayat Keluar</span>
                            </a>
                            <a href="{{ route('instock.history') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="receipt" class="w-5 h-5"/></span>
                                <span class="label">Riwayat Masuk</span>
                            </a>
                        @endif

                        <!-- Gudang Menu -->
                        @if(auth()->user()->role === 'gudang')
                            <a href="{{ route('products.index') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="box" class="w-5 h-5"/></span>
                                <span class="label">Produk</span>
                            </a>
                            <a href="{{ route('categories.index') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="folder" class="w-5 h-5"/></span>
                                <span class="label">Kategori</span>
                            </a>
                            <a href="{{ route('products.create') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="plus" class="w-5 h-5"/></span>
                                <span class="label">Tambah Produk</span>
                            </a>
                            <a href="{{ route('instock.create') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="download" class="w-5 h-5"/></span>
                                <span class="label">Catat Barang Masuk</span>
                            </a>
                            <a href="{{ route('instock.history') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="receipt" class="w-5 h-5"/></span>
                                <span class="label">Riwayat Masuk</span>
                            </a>
                        @endif

                        <!-- Shared Menu -->
                        @if(in_array(auth()->user()->role, ['cashier', 'gudang', 'admin']))
                            <a href="{{ route('transactions.scan') }}" class="block glass-menu-item">
                                <span class="icon"><x-icon name="camera" class="w-5 h-5"/></span>
                                <span class="label">Scan</span>
                            </a>
                        @endif
                    </nav>
                @endauth
            </div>

            <!-- FOOTER - TIDAK SCROLL -->
            <div class="sidebar-footer p-6">
                @guest
                    <a href="{{ route('login') }}" class="btn-blue w-full text-center py-3">
                        Masuk
                    </a>
                @else
                        <div class="mb-4 p-4 glass-card" style="opacity: 1; transform: translateY(0px); transition: opacity 0.5s, transform 0.5s;">
                        <div class="text-sm">
                            <div class="font-semibold text-black">{{ auth()->user()->name }}</div>
                            <div class="mt-2">
                                <span class="glass-tag">{{ ucfirst(auth()->user()->role) }}</span>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-blue w-full text-center py-3">
                            Keluar
                        </button>
                    </form>
                @endguest
            </div>

        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Notifications -->
                @if ($errors->any())
                    <div class="glass-card mb-6 bg-red-900/60 border border-red-700 px-6 py-4 rounded-xl mb-6">
                        <strong class="font-semibold">Kesalahan:</strong>
                        <ul class="list-disc ml-5 mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                    @if (session('success'))
                    <div class="glass-card mb-6 bg-green-900/60 border border-green-700 px-6 py-4 rounded-xl mb-6">
                        <div class="flex items-center gap-3">
                            <span class="text-xl"><x-icon name="check" class="w-6 h-6 text-white"/></span>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="glass-card mb-6 bg-red-900/60 border border-red-700 px-6 py-4 rounded-xl mb-6">
                        <div class="flex items-center gap-3">
                            <span class="text-xl"><x-icon name="close" class="w-6 h-6 text-white"/></span>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                <div class="glass-card p-8 mb-8">
                    @yield('content')
                </div>

                <!-- Footer -->
                <footer class="bg-gray-800 text-black text-center py-6 mt-8 rounded-2xl">
                    <p class="font-medium">&copy; 2025 Sistem Inventory. Hak cipta dilindungi.</p>
                    <p class="text-sm opacity-80 mt-2">Version 1.0 | Josep Design</p>
                </footer>
            </div>
        </main>
    </div>

    @stack('scripts')

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Highlight active menu based on current URL
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.glass-menu-item');

            menuItems.forEach(item => {
                const href = item.getAttribute('href');
                if (href && currentPath.includes(href.replace(/\//g, ''))) {
                    item.classList.add('active');
                }

                // Set exact match for better accuracy
                if (href === currentPath) {
                    item.classList.add('active');
                }
            });

            // Add ripple effect to buttons
            document.querySelectorAll('.btn-blue, .btn-cream').forEach(button => {
                button.addEventListener('click', function(e) {
                    let ripple = document.createElement('span');
                    let rect = this.getBoundingClientRect();
                    let size = Math.max(rect.width, rect.height);
                    let x = e.clientX - rect.left - size / 2;
                    let y = e.clientY - rect.top - size / 2;

                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.7);
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        width: ${size}px;
                        height: ${size}px;
                        top: ${y}px;
                        left: ${x}px;
                        pointer-events: none;
                    `;

                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });

            // Add animation to cards on load
            const cards = document.querySelectorAll('.glass-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Smooth scrolling for sidebar
            const sidebarNav = document.querySelector('.sidebar-nav');
            if (sidebarNav) {
                sidebarNav.addEventListener('wheel', function(e) {
                    e.preventDefault();
                    this.scrollTop += e.deltaY;
                }, { passive: false });
            }

            // Add CSS for ripple animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }

                /* Active menu item highlight */
                .glass-menu-item.active {
                    background: linear-gradient(135deg, var(--c1), var(--c5));
                    border-color: rgba(255, 255, 255, 0.3);
                    box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
                }

                .glass-menu-item.active .icon {
                    background: rgba(255, 255, 255, 0.2);
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>
