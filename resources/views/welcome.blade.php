@extends('layouts.ft')

@section('title', 'Sistem Inventory Josep')

@section('content')

<style>
    /* Custom styles untuk landing page yang konsisten */
    :root {
        --primary-cream: #F5E6D3;
        --primary-blue: #2A5298;
        --secondary-blue: #1E3C72;
        --light-cream: #FAF3E8;
        --dark-blue: #1A365D;
        --text-dark: #1F2937;
        --text-light: #6B7280;
    }

    .bg-black {
        background-color: var(--primary-white) !important;
    }

    .glass-pill {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: var(--text-dark);
        transition: all 0.3s ease;
    }

    .glass-pill:hover {
        background: rgba(255, 255, 255, 0.9);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        background: rgba(255, 255, 255, 0.95);
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(42, 82, 152, 0.15);
        border-color: var(--primary-blue);
    }

    .btn-cream {
        background-color: var(--primary-cream);
        color: var(--text-dark);
        border: 2px solid var(--primary-blue);
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-cream:hover {
        background-color: var(--primary-blue);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(42, 82, 152, 0.3);
    }

    .btn-blue {
        background-color: var(--primary-blue);
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-blue:hover {
        background-color: var(--secondary-blue);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(42, 82, 152, 0.3);
    }

    .text-black\/75 {
        color: rgba(31, 41, 55, 0.75) !important;
    }

    .text-black\/70 {
        color: rgba(31, 41, 55, 0.7) !important;
    }

    .text-black\/60 {
        color: rgba(31, 41, 55, 0.6) !important;
    }

    .border-black\/10 {
        border-color: rgba(31, 41, 55, 0.1) !important;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    /* Section spacing */
    section {
        opacity: 0;
    }

    section.visible {
        opacity: 1;
        transition: opacity 0.8s ease;
    }
</style>

<!-- Main Landing Page -->
<main class="bg-black text-black min-h-screen">
    <!-- Hero Section -->
    <section class="min-h-screen flex items-center visible">
        <div class="max-w-7xl mx-auto px-6 py-24 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="fade-in-up">
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-gray-900">Selamat Datang Di Sistem Inventory Josep</h1>
                    <p class="text-lg text-black/75 mb-6">Sistem Inventory Josep adalah solusi terintegrasi yang mengotomatiskan pencatatan stok, pemantauan barang masuk-keluar, dan analisis persediaan secara real-time, sehingga bisnis Anda dapat mengurangi waste, mengoptimalkan stok, dan meningkatkan efisiensi operasional.</p>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3 mb-8">
                        <a href="{{ route('login') }}" class="btn-cream inline-flex items-center px-6 py-3 rounded-lg text-base">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Masuk ke Sistem
                        </a>
                    </div>

                    <!-- Feature Pills -->
                    <div class="mt-8">
                        <p class="text-sm text-black/60 mb-3">Fitur yang tersedia:</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <div class="glass-pill p-3 text-center">
                                <div class="font-medium">Realtime Stock</div>
                                <div class="text-xs text-black/60">Update langsung</div>
                            </div>
                            <div class="glass-pill p-3 text-center">
                                <div class="font-medium">Laporan CSV/PDF</div>
                                <div class="text-xs text-black/60">Ekspor data</div>
                            </div>
                            <div class="glass-pill p-3 text-center">
                                <div class="font-medium">Cetak Label</div>
                                <div class="text-xs text-black/60">Custom template</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Illustration -->
                <div class="fade-in-up" style="animation-delay: 0.2s;">
                    <div class="relative">
                        <div class="glass-card p-6 rounded-2xl shadow-xl">
                            <!-- Dashboard Preview -->
                            <div class="mb-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                </div>
                                <div class="text-sm font-medium text-black/70">Dashboard Preview</div>
                            </div>

                            <!-- Mock Dashboard -->
                            <div class="space-y-4">
                                <!-- Stats Row -->
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="bg-blue-50 p-3 rounded-lg">
                                        <div class="text-xs text-black/60">Total Produk</div>
                                        <div class="text-xl font-bold text-blue-600">1,248</div>
                                    </div>
                                    <div class="bg-green-50 p-3 rounded-lg">
                                        <div class="text-xs text-black/60">Stok Aman</div>
                                        <div class="text-xl font-bold text-green-600">856</div>
                                    </div>
                                    <div class="bg-amber-50 p-3 rounded-lg">
                                        <div class="text-xs text-black/60">Hampir Habis</div>
                                        <div class="text-xl font-bold text-amber-600">12</div>
                                    </div>
                                </div>

                                <!-- Product List -->
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between p-2 bg-white/50 rounded">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded mr-3 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-medium">Produk A</div>
                                                <div class="text-xs text-black/60">Stok: 124</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold">Rp 125.000</div>
                                            <div class="text-xs text-green-600">+5%</div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between p-2 bg-white/50 rounded">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-green-100 rounded mr-3 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-medium">Produk B</div>
                                                <div class="text-xs text-black/60">Stok: 89</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold">Rp 89.500</div>
                                            <div class="text-xs text-green-600">+12%</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Action -->
                                <div class="pt-4 border-t border-black/10">
                                    <div class="flex space-x-2">
                                        <button class="flex-1 bg-blue-50 text-blue-700 py-2 rounded-lg text-sm font-medium hover:bg-blue-100 transition">
                                            Tambah Produk
                                        </button>
                                        <button class="flex-1 bg-green-50 text-green-700 py-2 rounded-lg text-sm font-medium hover:bg-green-100 transition">
                                            Scan Barcode
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Elements -->
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-blue-100 rounded-full opacity-50 blur-sm"></div>
                        <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-amber-100 rounded-full opacity-50 blur-sm"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 visible">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3 text-gray-900">Fitur Unggulan Sistem Inventory</h2>
                <p class="text-lg text-black/70 max-w-3xl mx-auto">Solusi lengkap untuk mengelola bisnis Anda dengan lebih efisien dan terorganisir</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="glass-card p-6">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900">Manajemen Stok Real-time</h3>
                    <p class="text-sm text-black/70">Input, update, dan pantau stok secara realtime dengan riwayat pergerakan produk yang lengkap dan terperinci.</p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-card p-6">
                    <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900">Scan & Cek Cepat</h3>
                    <p class="text-sm text-black/70">Pindai barcode/QR untuk melihat detail produk atau melakukan transaksi cepat tanpa perlu input manual.</p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-card p-6">
                    <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900">Cetak Label Custom</h3>
                    <p class="text-sm text-black/70">Buat dan cetak label produk dalam format PDF/PNG dengan template custom untuk inventaris atau penjualan.</p>
                </div>

                <!-- Feature 4 -->
                <div class="glass-card p-6">
                    <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900">Laporan & Ekspor Data</h3>
                    <p class="text-sm text-black/70">Ekspor laporan masuk/keluar, penjualan, dan stok ke CSV, PDF, atau Excel untuk analisa lebih lanjut.</p>
                </div>

                <!-- Feature 5 -->
                <div class="glass-card p-6">
                    <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 3.75a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900">Multi-User & Role</h3>
                    <p class="text-sm text-black/70">Atur akses untuk admin, gudang, dan kasir sesuai kebutuhan operasional dengan sistem permission yang fleksibel.</p>
                </div>

                <!-- Feature 6 -->
                <div class="glass-card p-6">
                    <div class="w-12 h-12 bg-teal-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900">Keamanan & Audit</h3>
                    <p class="text-sm text-black/70">Autentikasi yang aman dan log activity untuk audit internal serta tracking semua aktivitas pengguna.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 visible">
        <div class="max-w-4xl mx-auto px-6">
            <div class="glass-card p-8 md:p-12 text-center rounded-2xl">
                <div class="max-w-3xl mx-auto">
                    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold mb-4 text-gray-900">Masuk Inventory</h3>
                    <p class="text-lg text-black/70 mb-8 max-w-2xl mx-auto">Bergabunglah dengan ratusan bisnis yang telah menggunakan Sistem Inventory kami untuk mengelola inventaris dengan lebih efisien dan meningkatkan profitabilitas.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="btn-blue px-8 py-3 rounded-lg text-base font-semibold inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Daftar Akun Baru
                        </a>
                        <a href="{{ route('login') }}" class="btn-cream px-8 py-3 rounded-lg text-base font-semibold inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Masuk ke Akun Saya
                        </a>
                    </div>
                    <p class="text-sm text-black/60 mt-6">Tidak perlu kartu kredit untuk mencoba versi gratis</p>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    // Intersection Observer untuk animasi section
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('section');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });

        sections.forEach(section => {
            observer.observe(section);
        });

        // Smooth scroll untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>

@endsection
