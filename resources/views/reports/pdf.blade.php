<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Inventori</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; color:#000 }
        .header { text-align:center; margin-bottom:20px }
        table { width:100%; border-collapse:collapse }
        th, td { border:1px solid #ddd; padding:8px }
        th { background:#f4f4f4; font-weight:bold }
        .right { text-align:right }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Inventori</h2>
        <div>Tanggal: {{ date('Y-m-d H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th class="right">Nilai (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($byCategory as $row)
                <tr>
                    <td>{{ $row->category->name ?? 'Unknown' }}</td>
                    <td class="right">{{ number_format($row->value ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="font-weight:bold">Total</td>
                <td class="right" style="font-weight:bold">{{ number_format($totalValue ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
