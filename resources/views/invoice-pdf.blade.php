<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #343a40;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            margin: 8px 0;
            color: #555;
        }
        .total {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            color: #007bff;
        }
        .info {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Invoice</h2>
        <p class="info"><strong>Nama:</strong> {{ $invoice->customer->name }}</p>
        <p class="info"><strong>Tanggal:</strong> {{ $invoice->created_at->format('d M Y') }}</p>
        <p class="info"><strong>Meter Awal:</strong> {{ $invoice->meter_awal }}</p>
        <p class="info"><strong>Meter Akhir:</strong> {{ $invoice->meter_akhir }}</p>
        <p class="info"><strong>Pemakaian:</strong> {{ $invoice->pemakaian }} m³</p>
        <p class="total"><strong>Total Biaya:</strong> Rp {{ number_format($invoice->total, 0, ',', '.') }}</p>
    </div>
</body>
</html>
