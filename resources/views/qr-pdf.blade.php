<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Codes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            text-align: center;
            vertical-align: top;
            padding: 10px;
            border: 1px solid #ddd;
        }

        img {
            width: 150px;
            height: 150px;
        }

        p {
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <table>
        @foreach ($data->chunk(4) as $row)
            <!-- 3 kolom per baris -->
            <tr>
                @foreach ($row as $customer)
                    <td>
                        <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(150)->generate(json_encode($customer))) }}"
                            alt="QR Code">
                        <p><strong>{{ $customer['name'] }}</strong></p>
                        <p>{{ $customer['pam_code'] }}</p>
                        <p>{{ Str::limit($customer['address'], 50) }}</p>
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>

</html>
