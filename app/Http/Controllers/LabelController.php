<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class LabelController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Ensure SKU exists
        if (empty($product->sku)) {
            $product->sku = 'SKU' . str_pad($product->id, 6, '0', STR_PAD_LEFT);
            $product->save();
        }

        return view('labels.show', compact('product'));
    }

    public function printAll()
    {
        $products = Product::orderBy('id')->get();

        foreach ($products as $p) {
            if (empty($p->sku)) {
                $p->sku = 'SKU' . str_pad($p->id, 6, '0', STR_PAD_LEFT);
                $p->save();
            }
        }

        return view('labels.print', compact('products'));
    }

    /**
     * Export labels as a downloadable PDF (server-side)
     */
    public function exportPdf(Request $request)
    {
        $products = Product::orderBy('id')->get();

        foreach ($products as $p) {
            if (empty($p->sku)) {
                $p->sku = 'SKU' . str_pad($p->id, 6, '0', STR_PAD_LEFT);
                $p->save();
            }
        }

        // Attempt to generate server-side barcode images if Picqer is installed.
        $barcodeImages = [];
        if (class_exists('\\Picqer\\Barcode\\BarcodeGeneratorPNG')) {
            try {
                $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                foreach ($products as $p) {
                    $png = $generator->getBarcode($p->sku, $generator::TYPE_CODE_128);
                    $barcodeImages[$p->id] = 'data:image/png;base64,' . base64_encode($png);
                }
            } catch (\Throwable $e) {
                // ignore and fall back to text SKU in PDF
                $barcodeImages = [];
            }
        }

        $pdf = app('dompdf.wrapper')->loadView('labels.pdf', compact('products', 'barcodeImages'));
        $filename = 'labels_' . date('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export a single product label as PDF (server-side)
     */
    public function exportSingle($id)
    {
        $product = Product::findOrFail($id);

        if (empty($product->sku)) {
            $product->sku = 'SKU' . str_pad($product->id, 6, '0', STR_PAD_LEFT);
            $product->save();
        }

        $products = collect([$product]);

        $barcodeImages = [];
        if (class_exists('\Picqer\Barcode\BarcodeGeneratorPNG')) {
            try {
                $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                $png = $generator->getBarcode($product->sku, $generator::TYPE_CODE_128);
                $barcodeImages[$product->id] = 'data:image/png;base64,' . base64_encode($png);
            } catch (\Throwable $e) {
                $barcodeImages = [];
            }
        }

        $pdf = app('dompdf.wrapper')->loadView('labels.pdf', compact('products', 'barcodeImages'));
        $filename = 'label_' . ($product->sku ?: $product->id) . '_' . date('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }
}
