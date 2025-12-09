# 📦 Inventory Management System

Aplikasi Inventory Management System sederhana yang dibangun menggunakan **Laravel 12** dengan Tailwind CSS untuk interface yang modern dan responsif.

## Fitur Utama

✅ **Manajemen Produk**
- Tambah, edit, dan hapus produk
- Tracking stok produk real-time
- Kategorisasi produk
- Penyimpanan informasi detail produk

✅ **Manajemen Kategori**
- Buat dan kelola kategori produk
- Deskripsi kategori
- Tampilan jumlah produk per kategori

✅ **Tracking Stok**
- Otomatis mencatat pergerakan stok
- Tipe pergerakan (in/out)
- Referensi dan catatan untuk setiap pergerakan
- Riwayat pergerakan stok

✅ **Dashboard**
- Statistik produk total
- Jumlah kategori
- Alert produk stok rendah
- Tampilan produk out of stock
- Nilai total inventori

✅ **Status Produk**
- In Stock (hijau)
- Low Stock (kuning - di bawah minimum stok)
- Out of Stock (merah - stok 0)

## Requirements

- PHP 8.2 atau lebih tinggi
- Composer
- SQLite (default) atau database lainnya

## Instalasi & Menjalankan

### 1. Install Dependencies
```bash
composer install
```

### 2. Jalankan Migrations
```bash
php artisan migrate
```

### 3. Seeding Database (Optional)
```bash
php artisan db:seed
```

### 4. Jalankan Development Server
```bash
php artisan serve
```

Akses aplikasi di `http://127.0.0.1:8000/dashboard`

## Demo Credentials

Setelah menjalankan `php artisan db:seed`, berikut akun demo yang tersedia:

- **Admin**: `admin@inventory.com` / `admin123` (CRUD produk/kategori + laporan + export)
- **Cashier**: `cashier@inventory.com` / `cashier123` (catat barang keluar/masuk)
- **Gudang**: `gudang@inventory.com` / `gudang123` (catat barang masuk + pengecekan stok)

## Middleware & Permissions

- A custom middleware alias `role` is registered in `bootstrap/app.php`. Use it in routes like `->middleware('role:admin')` or `->middleware('role:cashier,gudang')`.
- Routes requiring authentication use the `auth` middleware provided by Laravel.

## Reports & Export

- Admins can view inventory reports at `/reports`.
- To export the report as CSV, use `/reports/export` (admin-only). The CSV contains per-category values and the total inventory value.

## Labels & Scanning

- Generate printable labels (barcode + QR) per product: visit `/labels/{id}` as Admin to view a product label and `/labels` to render labels for all products. Labels use client-side libraries to render Code128 barcodes and QR codes.
- Quick scan UI: `/transactions/scan` — supports keyboard barcode scanners (acts like typing + Enter) and camera scanning (QR/barcode) using `html5-qrcode`.
- If product SKU is missing the system will auto-generate a SKU in the form `SKU000001`.

### PDF export (server-side)

- The project supports server-side PDF export of labels using `barryvdh/laravel-dompdf`.
- To install the package:

```bash
composer require barryvdh/laravel-dompdf
```

- Export labels as a downloadable PDF (Admin): `GET /labels/export` — the server will generate a PDF file containing labels for all products. The PDF view is `resources/views/labels/pdf.blade.php` and can be customized.

Notes:
- Server-side barcode image generation can be improved by adding a barcode library or rendering barcodes to images before PDF generation. For now the PDF view prints the SKU as monospace text; if you want real barcode images embedded in the PDF, I can add `picqer/php-barcode-generator` or generate SVGs and include them in the view.

## Server-side barcode images (optional)

- To embed Code128 barcode PNGs directly into PDF labels, install `picqer/php-barcode-generator`:

```bash
composer require picqer/php-barcode-generator
```

- The `LabelController::exportPdf` will attempt to use `Picqer\Barcode\BarcodeGeneratorPNG` if available and embed base64 PNG images into the generated PDF. If that package is not installed the controller falls back to printing the SKU as monospace text and uses Google Chart API as a fallback QR image in the PDF.


## Storage link helper

If product images are not appearing, create the storage symbolic link:

```bash
php artisan storage:link
```

I've also added an admin-only helper route that runs this command for you (only use in a trusted environment): `POST /admin/storage-link` (requires Admin role).


## Struktur Aplikasi

```
├── app/Models/
│   ├── Product.php
│   ├── Category.php
│   └── StockMovement.php
├── app/Http/Controllers/
│   ├── DashboardController.php
│   ├── ProductController.php
│   └── CategoryController.php
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── dashboard.blade.php
│   ├── products/
│   └── categories/
└── routes/web.php
```

## Tech Stack

- **Backend**: Laravel 12
- **Database**: SQLite
- **Frontend**: Blade Templates + Tailwind CSS
- **Build Tool**: Vite

## License

MIT License
