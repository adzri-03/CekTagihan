<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; }
        h2 { text-align: center; color: #333; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        td, th { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .total { font-weight: bold; font-size: 18px; text-align: right; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Invoice </h2>
        <p><strong>Nama :</strong> {{ $invoice->customer->name }}</p>
        <p><strong>Tanggal:</strong> {{ $invoice->created_at->format('d M Y') }}</p>
        <p><strong>Meter Awal:</strong> {{ $invoice->meter_awal }}</p>
        <p><strong>Meter Akhir:</strong> {{ $invoice->meter_akhir }}</p>
        <p><strong>Pemakaian:</strong> {{ $invoice->pemakaian }} m³</p>
        <p class="total"><strong>Total Biaya:</strong> Rp {{ number_format($invoice->total, 0, ',', '.') }}</p>
    </div>
</body>
</html>
