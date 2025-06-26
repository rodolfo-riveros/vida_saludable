<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10mm; /* Márgenes reducidos para más espacio de contenido */
            color: #333;
        }
        .header {
            display: flex;
            justify-content: flex-end; /* Alinear logo a la derecha */
            margin-bottom: 10px;
        }
        .logo img {
            max-width: 200px; /* Logo más grande, ajustar según sea necesario */
            height: auto;
        }
        h1 {
            text-align: center; /* Menos centrado, alineado a la izquierda */
            color: #1a73e8;
            font-size: 20px; /* Un poco más pequeño para apariencia tipo hoja de cálculo */
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px; /* Fuente más pequeña para apariencia compacta */
        }
        th, td {
            border: 1px solid #999; /* Bordes más oscuros para aspecto de cuadrícula */
            padding: 6px; /* Espaciado reducido para mayor compacidad */
            text-align: left;
        }
        th {
            background-color: #e0e0e0; /* Encabezado más oscuro para contraste */
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f5f5f5; /* Filas pares más claras para legibilidad */
        }
        .footer {
            text-align: center; /* Alinear pie de página a la izquierda para consistencia */
            margin-top: 15px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('image/logo_VidaSaludable.png') }}" alt="Logo">
        </div>
    </div>
    <h1>Reporte de Productos</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Categoría</th>
                <th>Proveedor</th>
                <th>Nombre</th>
                <th>Código de barra</th>
                <th>Precio venta</th>
                <th>Precio compra</th>
                <th>Stock</th>
                <th>Stock mínimo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($product->category->name ?? '', 20) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($product->supplier->razon_social ?? '', 20) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($product->name, 20) }}</td>
                    <td>{{ $product->codigo_barra }}</td>
                    <td>{{ number_format($product->precio_venta, 2) }}</td>
                    <td>{{ number_format($product->precio_compra, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->stock_minimo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} | Sistema de Gestión Vida Saludable
    </div>
</body>
</html>
<!DOCTYPE html>
