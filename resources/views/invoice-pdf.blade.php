<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Invoice Pembayaran - {{ $invoice->customer->pam_code }}</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            padding: 5mm;
        }

        .container {
            width: 100%;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 3mm;
        }

        .header h1 {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 1mm;
        }

        .header p {
            font-size: 8pt;
            color: #666;
        }

        /* Separator */
        .separator {
            border-top: 1px dashed #000;
            margin: 2mm 0;
        }

        /* Customer Info */
        .customer-info {
            margin: 3mm 0;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 1mm;
        }

        .info-label {
            display: table-cell;
            width: 30%;
            font-weight: bold;
        }

        .info-value {
            display: table-cell;
            width: 70%;
        }

        /* Meter Reading */
        .meter-reading {
            margin: 3mm 0;
        }

        /* Total */
        .total {
            margin: 3mm 0;
            font-weight: bold;
            font-size: 11pt;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 5mm;
            font-size: 8pt;
        }

        .qr-placeholder {
            text-align: center;
            margin: 3mm 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>INVOICE PEMBAYARAN PAM</h1>
            <p>{{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="separator"></div>

        <div class="customer-info">
            <div class="info-row">
                <span class="info-label">Nama</span>
                <span class="info-value">: {{ $invoice->customer->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kode PAM</span>
                <span class="info-value">: {{ $invoice->customer->pam_code }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Alamat</span>
                <span class="info-value">: {{ $invoice->customer->address }}</span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="meter-reading">
            <div class="info-row">
                <span class="info-label">Meter Awal</span>
                <span class="info-value">: {{ number_format($invoice->meter_awal, 0, ',', '.') }} m³</span>
            </div>
            <div class="info-row">
                <span class="info-label">Meter Akhir</span>
                <span class="info-value">: {{ number_format($invoice->meter_akhir, 0, ',', '.') }} m³</span>
            </div>
            <div class="info-row">
                <span class="info-label">Pemakaian</span>
                <span class="info-value">: {{ number_format($invoice->pemakaian, 0, ',', '.') }} m³</span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="total">
            <div class="info-row">
                <span class="info-label">Total Biaya</span>
                <span class="info-value">: Rp {{ number_format($invoice->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih atas pembayaran Anda</p>
            <p>Invoice ini digenerate otomatis pada {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>