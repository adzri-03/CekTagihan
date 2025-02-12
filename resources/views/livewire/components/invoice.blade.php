<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Invoice Pembayaran - {{ $data->customer->pam_code }}</title>
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
                <span class="info-value">: {{ $data->customer->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kode PAM</span>
                <span class="info-value">: {{ $data->customer->pam_code }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Alamat</span>
                <span class="info-value">: {{ $data->customer->address }}</span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="meter-reading">
            <div class="info-row">
                <span class="info-label">Meter Awal</span>
                <span class="info-value">: {{ number_format($data->meter_awal, 0, ',', '.') }} m³</span>
            </div>
            <div class="info-row">
                <span class="info-label">Meter Akhir</span>
                <span class="info-value">: {{ number_format($data->meter_akhir, 0, ',', '.') }} m³</span>
            </div>
            <div class="info-row">
                <span class="info-label">Pemakaian</span>
                <span class="info-value">: {{ number_format($data->pemakaian, 0, ',', '.') }} m³</span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="total">
            <div class="info-row">
                <span class="info-label">Total Biaya</span>
                <span class="info-value">: Rp {{ number_format($data->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih atas pembayaran Anda</p>
            <p>Invoice ini digenerate otomatis pada {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
{{-- <!DOCTYPE html>
<html>

<head>
    <style>
        * {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 8pt;
            line-height: 1.2;
        }

        .header {
            text-align: center;
            margin-bottom: 3mm;
        }

        .header h1 {
            font-size: 10pt;
            font-weight: bold;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 2mm 0;
        }

        .table td {
            padding: 1mm 0;
        }

        .bold {
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 3mm 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>PDAM KOTA CONTOH</h1>
        <p>Jl. Contoh No. 123 | Telp: (021) 12345678</p>
    </div>

    <table class="table">
        <tr>
            <td width="35%">Pelanggan</td>
            <td>: {{ $data->name }}</td>
        </tr>
        <tr>
            <td>Kode PAM</td>
            <td>: {{ $data->pam_code }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: {{ $data->created_at->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table class="table">
        <tr>
            <td width="60%">Meter Awal</td>
            <td>{{ number_format($data->meter_awal, 0, ',', '.') }} m³</td>
        </tr>
        <tr>
            <td>Meter Akhir</td>
            <td>{{ number_format($data->meter_akhir, 0, ',', '.') }} m³</td>
        </tr>
        <tr class="bold">
            <td>Pemakaian</td>
            <td>{{ number_format($data->pemakaian, 0, ',', '.') }} m³</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table class="table">
        <tr class="bold">
            <td width="60%">TOTAL TAGIHAN</td>
            <td>Rp {{ number_format($data->total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <p style="text-align: center; margin-top: 3mm">
        ** Bayar sebelum {{ now()->addDays(7)->format('d/m/Y') }} **
    </p>
</body>

</html> --}}
