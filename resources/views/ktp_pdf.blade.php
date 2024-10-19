<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data KTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <h1>Data KTP</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Alamat</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ktps as $ktp)
            <tr>
                <td>{{ $ktp->id }}</td>
                <td>{{ $ktp->nama }}</td>
                <td>{{ $ktp->nik }}</td>
                <td>{{ $ktp->alamat }}</td>
                <td>{{ $ktp->tempat_lahir }}</td>
                <td>{{ $ktp->tanggal_lahir }}</td>
                <td>{{ $ktp->created_at }}</td>
                <td>{{ $ktp->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>