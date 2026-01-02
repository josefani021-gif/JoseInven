@extends('layouts.app')

@section('title', 'Scan Produk')

@section('content')
<div class="glass-card p-6 rounded-2xl">
    <div class="flex items-center justify-between mb-6">
        <div>
                <h2 class="text-2xl font-bold text-black flex items-center gap-2">
                <x-icon name="camera" class="w-7 h-7 text-black-400"/> Scan Produk
            </h2>
            <p class="text-sm text-gray-600 mt-1">Scan barcode/QR code produk untuk melihat detail dan mengatur stok</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="glass-tag flex items-center gap-1">
                <x-icon name="bolt" class="w-4 h-4"/> Real-time
            </span>
        </div>
    </div>

    <!-- Scanner Input Section -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
            <label class="block text-sm font-semibold text-black">Input Scanner</label>
            <span class="text-xs text-gray-500">(gunakan barcode scanner atau masukkan manual)</span>
        </div>
        <div class="relative">
            <input
                id="scannerInput"
                type="text"
                class="w-full border border-gray-300 px-4 py-3 rounded-xl bg-white text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                placeholder="Scan atau ketik SKU/Barcode lalu tekan Enter..."
                autofocus
            />
            <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                <span class="text-gray-400">↵ Enter</span>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-2">Tekan Enter setelah scan/input untuk mencari produk</p>
    </div>

    <!-- Camera Scanner Section -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-3">
            <label class="block text-sm font-semibold text-black">Scanner Kamera</label>
            <span id="cameraStatus" class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">Mati</span>
        </div>
        <div class="flex flex-wrap gap-3 mb-4">
            <button id="openCamera" class="btn-blue flex items-center gap-2">
                <x-icon name="camera" class="w-5 h-5"/> Buka Scanner Kamera
            </button>
            <button id="switchCamera" class="btn-cream flex items-center gap-2" style="display: none;">
                <x-icon name="switch" class="w-5 h-5"/> Ganti Kamera
            </button>
            <button id="stopCamera" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl flex items-center gap-2 transition-all" style="display: none;">
                <x-icon name="stop" class="w-5 h-5"/> Stop Scanner
            </button>
        </div>

        <div id="reader" class="rounded-xl overflow-hidden border-2 border-dashed border-gray-300" style="width:100%;max-width:500px;display:none;margin:0 auto;"></div>

        <div class="mt-3 text-center">
            <p class="text-sm text-gray-600">Arahkan kamera ke barcode/QR code produk</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-6">
        <h3 class="text-sm font-semibold text-black mb-3">Aksi Cepat</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <button onclick="quickScan('sku001')" class="glass-menu-item text-center justify-center text-black flex flex-col items-center gap-1 py-3">
                <x-icon name="box" class="w-7 h-7" />
                <span class="label text-xs">SKU001</span>
            </button>
            <button onclick="quickScan('sku002')" class="glass-menu-item text-center justify-center text-black flex flex-col items-center gap-1 py-3">
                <x-icon name="box" class="w-7 h-7" />
                <span class="label text-xs">SKU002</span>
            </button>
            <button onclick="quickScan('sku003')" class="glass-menu-item text-center justify-center text-black flex flex-col items-center gap-1 py-3">
                <x-icon name="box" class="w-7 h-7" />
                <span class="label text-xs">SKU003</span>
            </button>
            <button onclick="showRecentScans()" class="glass-menu-item text-center justify-center text-black flex flex-col items-center gap-1 py-3">
                <x-icon name="clipboard" class="w-7 h-7" />
                <span class="label text-xs">Riwayat</span>
            </button>
        </div>
    </div>

    <!-- Results Section dengan tombol tutup -->
    <div id="resultSection" class="mt-6" style="display: none;">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-black flex items-center gap-2">
                <x-icon name="chart" class="w-5 h-5"/> Hasil Scan
            </h3>
            <div class="flex items-center gap-2">
                <button id="clearResultBtn" class="text-sm px-3 py-1 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                    <x-icon name="close" class="w-4 h-4 inline mr-2"/>Hapus
                </button>
                <button id="toggleAutoClearBtn" class="text-sm px-3 py-1 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors">
                    <x-icon name="clock" class="w-4 h-4 inline mr-2"/>Auto-clear: ON
                </button>
            </div>
        </div>
        <div id="result" class="space-y-4">
            <!-- Results will be displayed here -->
        </div>
    </div>

    <!-- Recent Scans -->
    <div id="recentScans" class="mt-6" style="display: none;">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-black"><x-icon name="clipboard" class="w-5 h-5 inline mr-2"/>Riwayat Scan Terakhir</h3>
            <button onclick="hideRecentScans()" class="text-sm px-3 py-1 bg-gray-100 text-gray-600 rounded-lg">
                <x-icon name="close" class="w-4 h-4 inline mr-2"/>Tutup
            </button>
        </div>
        <div id="recentList" class="space-y-2"></div>
    </div>
</div>

<!-- Audio for scan success -->
<audio id="scanSound" src="https://assets.mixkit.co/active_storage/sfx/249/249-preview.mp3" preload="auto"></audio>

<script src="https://unpkg.com/html5-qrcode@2.3.8/minified/html5-qrcode.min.js"></script>
<script>
    // Variables
    const input = document.getElementById('scannerInput');
    const resultEl = document.getElementById('result');
    const resultSection = document.getElementById('resultSection');
    const readerEl = document.getElementById('reader');
    const openCameraBtn = document.getElementById('openCamera');
    const stopCameraBtn = document.getElementById('stopCamera');
    const switchCameraBtn = document.getElementById('switchCamera');
    const cameraStatus = document.getElementById('cameraStatus');
    const recentScansEl = document.getElementById('recentScans');
    const recentListEl = document.getElementById('recentList');
    const scanSound = document.getElementById('scanSound');
    const clearResultBtn = document.getElementById('clearResultBtn');
    const toggleAutoClearBtn = document.getElementById('toggleAutoClearBtn');

    let html5QrCode = null;
    const AUTO_OPEN_CAMERA = true; // set to true to auto-open camera on page load
    let currentCameraId = null;
    let cameras = [];
    let recentScans = JSON.parse(localStorage.getItem('recentScans') || '[]');
    let autoClearEnabled = false; // MATIKAN auto-clear secara default
    let autoClearTimer = null;
    const currencyFormatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    });

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateRecentScansUI();
        updateAutoClearButton();

        // Auto-focus input
        input.focus();

        // Get available cameras
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                cameras = devices;
                console.log(`${cameras.length} kamera tersedia`);
                if (AUTO_OPEN_CAMERA) {
                    // small delay to allow UI to settle and avoid popup suppression
                    setTimeout(() => {
                        try {
                            if (openCameraBtn) openCameraBtn.click();
                        } catch (e) {
                            console.warn('Auto-open camera failed', e);
                        }
                    }, 500);
                }
            }
        }).catch(err => {
            console.error("Tidak dapat mengakses kamera:", err);
        });

        // Setup button handlers
        clearResultBtn.addEventListener('click', clearResult);
        toggleAutoClearBtn.addEventListener('click', toggleAutoClear);
    });

    // Keyboard input handler
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const code = input.value.trim();
            if (code) {
                fetchProduct(code);
                input.value = '';
                input.focus();
            }
        }
    });

    // Camera control
    openCameraBtn.addEventListener('click', async function () {
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("reader");
        }

        if (readerEl.style.display === 'none') {
            try {
                readerEl.style.display = 'block';
                openCameraBtn.style.display = 'none';
                stopCameraBtn.style.display = 'flex';
                if (cameras.length > 1) switchCameraBtn.style.display = 'flex';
                cameraStatus.textContent = 'Aktif';
                cameraStatus.className = 'text-xs px-2 py-1 rounded-full bg-green-100 text-green-600';

                const cameraId = currentCameraId || (cameras.length > 1 ? cameras[1].id : undefined);

                await html5QrCode.start(
                    cameraId || { facingMode: "environment" },
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    },
                    onScanSuccess,
                    onScanError
                );

            } catch (err) {
                console.error(err);
                alert('Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.');
                stopCamera();
            }
        }
    });

    stopCameraBtn.addEventListener('click', stopCamera);

    switchCameraBtn.addEventListener('click', async function() {
        if (html5QrCode && cameras.length > 1) {
            await stopCamera();

            // Switch to next camera
            const currentIndex = cameras.findIndex(cam => cam.id === currentCameraId);
            const nextIndex = (currentIndex + 1) % cameras.length;
            currentCameraId = cameras[nextIndex].id;

            // Restart with new camera
            setTimeout(() => openCameraBtn.click(), 300);
        }
    });

    function stopCamera() {
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                readerEl.style.display = 'none';
                openCameraBtn.style.display = 'flex';
                stopCameraBtn.style.display = 'none';
                switchCameraBtn.style.display = 'none';
                cameraStatus.textContent = 'Mati';
                cameraStatus.className = 'text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600';
            }).catch(err => {
                console.error("Error stopping camera:", err);
            });
        }
    }

    // Scan success handler
    function onScanSuccess(decodedText) {
        // Play success sound
        scanSound.currentTime = 0;
        scanSound.play().catch(e => console.log("Audio error:", e));

        // Visual feedback
        readerEl.style.borderColor = '#10B981';
        setTimeout(() => {
            readerEl.style.borderColor = '#D1D5DB';
        }, 300);

        fetchProduct(decodedText);

        // Stop camera after successful scan (optional)
        // stopCamera();
    }

    function onScanError(error) {
        // console.warn(`Scan error: ${error}`);
    }

    // Fetch product data
    async function fetchProduct(code) {
        if (!code) return;

        // Show loading
        resultSection.style.display = 'block';
        resultEl.innerHTML = `
            <div class="glass-card p-6 text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
                <p class="mt-4 text-black">Mencari produk dengan kode: <strong>${code}</strong></p>
            </div>
        `;

        try {
            const response = await fetch("{{ route('api.products.scan') }}?code=" + encodeURIComponent(code));
            const data = await response.json();

            if (data.error) {
                resultEl.innerHTML = `
                    <div class="glass-card p-6 border-l-4 border-red-500">
                        <div class="flex items-center gap-3">
                                <x-icon name="close" class="text-2xl text-red-500"/>
                                <div>
                                    <h4 class="font-semibold text-black">Produk Tidak Ditemukan</h4>
                                    <p class="text-gray-600 mt-1">Kode: ${code}</p>
                                    <p class="text-sm text-red-500 mt-2">${data.error}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex gap-2">
                                <button onclick="quickScan('${code}')" class="text-sm px-3 py-1 bg-blue-100 text-blue-600 rounded-lg"><x-icon name="switch" class="inline-block mr-2 w-4 h-4"/>Coba Lagi</button>
                                <a href="{{ route('products.create') }}" class="text-sm px-3 py-1 bg-green-100 text-green-600 rounded-lg"><x-icon name="plus" class="inline-block mr-2 w-4 h-4"/>Tambah Produk</a>
                            </div>
                    </div>
                `;

                // Start auto-clear timer for errors
                if (autoClearEnabled) {
                    startAutoClearTimer();
                }
                return;
            }

            const p = data.product;

            // Add to recent scans
            addToRecentScans(p);

            // Display product info
            resultEl.innerHTML = `
                <div class="glass-card p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="text-xl font-bold text-black">${p.name}</h4>
                            <p class="text-gray-600">SKU: <span class="font-mono">${p.sku}</span></p>
                        </div>
                        <span class="glass-tag">${p.category || 'Uncategorized'}</span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Stok</div>
                            <div class="text-2xl font-bold ${p.quantity < 10 ? 'text-red-500' : 'text-green-500'}">${p.quantity}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Harga</div>
                            <div class="text-2xl font-bold text-blue-500">${currencyFormatter.format(p.price)}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Nilai Total</div>
                            <div class="text-xl font-semibold">${currencyFormatter.format(p.price * p.quantity)}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Status</div>
                                <div class="text-lg font-semibold ${p.quantity > 20 ? 'text-green-500' : p.quantity > 5 ? 'text-yellow-500' : 'text-red-500'}">
                                ${p.quantity > 20 ? '<span class="inline-flex items-center"><span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-2"></span>Aman</span>' : p.quantity > 5 ? '<span class="inline-flex items-center"><span class="inline-block w-3 h-3 rounded-full bg-yellow-400 mr-2"></span>Sedikit</span>' : '<span class="inline-flex items-center"><span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-2"></span>Habis</span>'}
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="text-sm text-gray-500 mb-2">Deskripsi</div>
                        <p class="text-black">${p.description || 'Tidak ada deskripsi'}</p>
                    </div>

                    <div class="flex flex-wrap gap-3 mt-6">
                        <a href="{{ route('products.index') }}/${p.id}/edit" class="btn-blue">
                            <x-icon name="edit" class="inline-block mr-2 w-4 h-4"/> Edit Produk
                        </a>
                        <a href="{{ route('instock.create') }}?product_id=${p.id}" class="btn-cream">
                            <x-icon name="download" class="inline-block mr-2 w-4 h-4"/> Tambah Stok
                        </a>
                        <a href="{{ route('outstock.create') }}?product_id=${p.id}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl">
                            <x-icon name="upload" class="inline-block mr-2 w-4 h-4"/> Kurangi Stok
                        </a>
                        <button onclick="printLabel('${p.id}')" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-xl">
                            <x-icon name="tag" class="inline-block mr-2 w-4 h-4"/> Cetak Label
                        </button>
                    </div>
                </div>

                <div class="glass-card p-4 mt-4">
                    <div class="text-sm text-gray-500">Terakhir diupdate:</div>
                    <div class="text-black">${new Date(p.updated_at).toLocaleString('id-ID')}</div>
                </div>
            `;

            // Start auto-clear timer if enabled
            if (autoClearEnabled) {
                startAutoClearTimer();
            }

        } catch (err) {
            console.error('Fetch error:', err);
            resultEl.innerHTML = `
                <div class="glass-card p-6 border-l-4 border-red-500">
                    <div class="flex items-center gap-3">
                        <x-icon name="bolt" class="text-2xl text-yellow-400"/>
                        <div>
                            <h4 class="font-semibold text-black">Kesalahan Jaringan</h4>
                            <p class="text-gray-600 mt-1">Tidak dapat terhubung ke server</p>
                        </div>
                    </div>
                    <button onclick="fetchProduct('${code}')" class="mt-4 text-sm px-3 py-1 bg-blue-100 text-blue-600 rounded-lg">
                        <x-icon name="switch" class="inline-block mr-2 w-4 h-4"/>Coba Lagi
                    </button>
                </div>
            `;

            // Start auto-clear timer for errors
            if (autoClearEnabled) {
                startAutoClearTimer();
            }
        }
    }

    // Clear result function
    function clearResult() {
        resultSection.style.display = 'none';
        resultEl.innerHTML = '';

        // Clear any existing timer
        if (autoClearTimer) {
            clearTimeout(autoClearTimer);
            autoClearTimer = null;
        }
    }

    // Toggle auto-clear function
    function toggleAutoClear() {
        autoClearEnabled = !autoClearEnabled;
        updateAutoClearButton();

        if (autoClearEnabled && resultEl.innerHTML && resultSection.style.display !== 'none') {
            // If auto-clear is enabled and there's a result showing, start timer
            startAutoClearTimer();
        } else if (!autoClearEnabled && autoClearTimer) {
            // If auto-clear is disabled, clear any existing timer
            clearTimeout(autoClearTimer);
            autoClearTimer = null;
        }

        // Save preference to localStorage
        localStorage.setItem('scanAutoClear', autoClearEnabled.toString());
    }

    function updateAutoClearButton() {
        const savedPref = localStorage.getItem('scanAutoClear');
        if (savedPref !== null) {
            autoClearEnabled = savedPref === 'true';
        }

        toggleAutoClearBtn.textContent = autoClearEnabled
            ? '⏰ Auto-clear: ON'
            : '⏰ Auto-clear: OFF';
        toggleAutoClearBtn.className = autoClearEnabled
            ? 'text-sm px-3 py-1 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition-colors'
            : 'text-sm px-3 py-1 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors';
    }

    function startAutoClearTimer() {
        // Clear any existing timer
        if (autoClearTimer) {
            clearTimeout(autoClearTimer);
        }

        // Set new timer for 30 seconds (30000 ms)
        autoClearTimer = setTimeout(() => {
            if (autoClearEnabled && resultEl.innerHTML && !document.hidden) {
                resultSection.style.display = 'none';
                resultEl.innerHTML = '';
                autoClearTimer = null;
            }
        }, 30000); // 30 seconds
    }

    // Recent scans management
    function addToRecentScans(product) {
        // Remove if already exists
        recentScans = recentScans.filter(p => p.id !== product.id);

        // Add to beginning
        recentScans.unshift({
            id: product.id,
            name: product.name,
            sku: product.sku,
            quantity: product.quantity,
            price: product.price,
            scannedAt: new Date().toISOString()
        });

        // Keep only last 10 scans
        recentScans = recentScans.slice(0, 10);

        // Save to localStorage
        localStorage.setItem('recentScans', JSON.stringify(recentScans));

        // Update UI
        updateRecentScansUI();
    }

    function updateRecentScansUI() {
        if (recentScans.length === 0) return;

        recentListEl.innerHTML = recentScans.map(product => `
            <div class="glass-menu-item flex justify-between items-center">
                <div>
                    <div class="font-medium text-black">${product.name}</div>
                    <div class="text-xs text-gray-500">${product.sku} • Stok: ${product.quantity}</div>
                </div>
                <button onclick="fetchProduct('${product.sku}')" class="text-blue-500 hover:text-blue-700">
                    🔍 Scan Lagi
                </button>
            </div>
        `).join('');
    }

    function showRecentScans() {
        recentScansEl.style.display = 'block';
    }

    function hideRecentScans() {
        recentScansEl.style.display = 'none';
    }

    // Quick scan function
    function quickScan(code) {
        input.value = code;
        fetchProduct(code);
        input.value = '';
        input.focus();
    }

    // Print label function
    function printLabel(productId) {
        window.open("{{ route('labels.print') }}?product_id=" + productId, '_blank');
    }

    // HAPUS fungsi auto-clear yang lama (yang menyebabkan masalah)
    // setInterval(() => {
    //     if (resultEl.innerHTML && !document.hidden) {
    //         const timeSinceLastScan = Date.now() - (window.lastScanTime || 0);
    //         if (timeSinceLastScan > 30000) { // 30 seconds
    //             resultSection.style.display = 'none';
    //             resultEl.innerHTML = '';
    //         }
    //     }
    // }, 5000);

    // Track last scan time (for future features if needed)
    window.addEventListener('scan', () => {
        window.lastScanTime = Date.now();
    });
</script>

@endsection
