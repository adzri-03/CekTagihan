<!DOCTYPE html>
<html>
<head>
    <style>
        /* CSS khusus untuk mPDF */
        body {
            font-family: DejaVu Sans, sans-serif; /* Gunakan font yang di-support */
            margin: 0;
        }
        table {
            width: 100%;
            border-spacing: 0; /* Alternatif untuk border-collapse */
        }
        td {
            width: 25%; /* 4 kolom per baris */
            text-align: center;
            padding: 5px;
            border: 1px solid #ddd;
            page-break-inside: avoid; /* Hindari potong tabel antar halaman */
        }
        img {
            width: 150px;
            height: 150px;
        }
        p {
            margin: 2px 0;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <table>
        @foreach ($data->chunk(4) as $row)
            <tr>
                @foreach ($row as $customer)
                    <td>
                        <img src="data:image/png;base64,{{ $customer['qr_code'] }}" alt="QR">
                        <p><strong>{{ Str::limit($customer['name'], 30) }}</strong></p>
                        <p>{{ $customer['pam_code'] }}</p>
                        <p>{{ Str::limit($customer['address'], 40) }}</p>
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>
</html>
