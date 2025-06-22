<!DOCTYPE html>
<html>

<head>
    <title>Toko Elektronik</title>
    <style>
        body {
            font-family: sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Toko Elektronik</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
