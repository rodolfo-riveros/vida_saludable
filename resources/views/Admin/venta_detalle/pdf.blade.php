<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Detalle Venta</title>
    <style>
        :root {
            --primary-color: #1a73e8; /* Azul primario */
            --header-bg: #e0e0e0; /* Fondo de encabezado principal */
            --even-row-bg: #f5f5f5; /* Fondo de fila par */
            --text-color: #333; /* Color de texto principal */
            --footer-color: #777; /* Color de texto del pie de página */
            --border-color: #ccc; /* Color de borde de tabla */
            --table-font-size: 12px;
            --detail-font-size: 11px;

            /* Nuevas variables para detalles */
            --detail-header-bg: #eef; /* Fondo de encabezado de detalle (azul muy claro) */
            --detail-row-bg: #fcfcfc; /* Fondo de fila de detalle alterno */
            --detail-border-color: #ddd; /* Borde de detalle más suave */
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Fuente más moderna */
            margin: 15mm; /* Márgenes ligeramente mayores */
            color: var(--text-color);
            font-size: var(--table-font-size);
            line-height: 1.5; /* Mayor interlineado para legibilidad */
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15mm; /* Mayor espacio después del encabezado */
            flex-direction: column; /* Centra el logo y el título */
        }

        .logo img {
            max-width: 150px; /* Reducir un poco el logo para no dominar */
            height: auto;
            margin-bottom: 5mm;
            opacity: 0.9; /* Pequeña transparencia para suavizar */
        }

        h1 {
            color: var(--primary-color);
            font-size: 24px; /* Título un poco más grande */
            font-weight: 600; /* Semibold */
            margin-bottom: 10mm; /* Espacio debajo del título */
            text-align: center;
            letter-spacing: 0.5px; /* Pequeño espaciado entre letras */
        }

        .report-section {
            margin-bottom: 15mm; /* Espacio entre secciones de reporte */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8mm; /* Espacio antes de los detalles o entre tablas */
            box-shadow: 0 0 5px rgba(0,0,0,0.05); /* Sutil sombra para dar profundidad */
        }

        th, td {
            border: 1px solid var(--border-color);
            padding: 8px 10px; /* Padding un poco mayor */
            text-align: left;
            vertical-align: middle; /* Alineación vertical central */
        }

        th {
            background-color: var(--header-bg);
            font-weight: bold;
            text-align: center;
            color: var(--text-color);
            text-transform: uppercase; /* Mayúsculas para encabezados */
            font-size: calc(var(--table-font-size) - 1px); /* Un poco más pequeño que el texto de tabla */
        }

        tbody tr:nth-child(even) {
            background-color: var(--even-row-bg);
        }
        tbody tr:hover {
            background-color: #eaf2ff; /* Resaltar fila al pasar el mouse (si fuera interactivo) */
        }


        .sale-details-container {
            width: 100%;
            /* Quitar el padding:0 del td colspan para controlar el espacio aquí */
            padding-left: 15px; /* Indentación para diferenciar los detalles */
            padding-right: 15px;
            padding-top: 5px;
            padding-bottom: 10px;
            background-color: #fcfdff; /* Fondo muy claro para la sección de detalles */
            border: 1px solid var(--detail-border-color);
            border-top: none; /* Elimina el borde superior para que se "una" con la fila principal */
            margin-top: -1px; /* Para que se superponga ligeramente y parezca continuo */
        }

        .sale-details-container strong {
            display: block; /* Para que el título "Detalles de la Venta" esté en su propia línea */
            margin-bottom: 5px;
            font-size: calc(var(--table-font-size) + 1px);
            color: var(--primary-color);
            border-bottom: 1px dashed var(--detail-border-color); /* Separador sutil */
            padding-bottom: 3px;
        }

        .sale-details-container table {
            margin-bottom: 0; /* No hay margen inferior para esta tabla interna */
            box-shadow: none; /* Sin sombra para la tabla interna */
        }

        .sale-details-container th {
            background-color: var(--detail-header-bg);
            font-size: var(--detail-font-size);
            padding: 5px 8px; /* Reducir padding en detalles */
        }

        .sale-details-container td {
            font-size: var(--detail-font-size);
            padding: 5px 8px;
            border-color: var(--detail-border-color);
        }

        .sale-details-container tr:nth-child(even) {
            background-color: var(--detail-row-bg);
        }

        .no-data {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: var(--footer-color);
            background-color: var(--even-row-bg);
            border: 1px dashed var(--border-color);
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: var(--footer-color);
            margin-top: 15mm; /* Más espacio antes del pie de página */
            border-top: 1px solid var(--border-color);
            padding-top: 8mm; /* Más padding en el pie de página */
        }

        /* Alineaciones específicas */
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .amount {
            font-weight: bold;
            color: #0056b3; /* Un azul más oscuro para montos */
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('image/logo_VidaSaludable.png') }}" alt="Logo">
        </div>
        <h1>Reporte Detalle de Ventas</h1>
    </div>

    <div class="report-section">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Comprobante</th>
                    <th>Fecha</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right">IGV</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sales as $sale)
                    <tr>
                        <td class="text-center">#{{ $sale->id }}</td>
                        <td>
                            <strong>{{ $sale->customer->nombres }} {{ $sale->customer->apellidos }}</strong><br>
                            <small>{{ $sale->customer->numero_documento }}</small>
                        </td>
                        <td class="text-center">{{ $sale->tipo_comprobante }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($sale->fecha)->format('d/m/Y') }}</td>
                        <td class="text-right amount">S/ {{ number_format($sale->subtotal, 2) }}</td>
                        <td class="text-right amount">S/ {{ number_format($sale->igv, 2) }}</td>
                        <td class="text-right amount">S/ {{ number_format($sale->total, 2) }}</td>
                    </tr>
                    @if(count($sale->saleDetails))
                        <tr>
                            <td colspan="7">
                                <div class="sale-details-container">
                                    <strong>Detalles de la Venta #{{ $sale->id }}</strong>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th class="text-center">Código</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-right">Precio Unitario</th>
                                                <th class="text-right">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sale->saleDetails as $detail)
                                                <tr>
                                                    <td>
                                                        {{ $detail->product->name }}<br>
                                                        <small>{{ $detail->product->marca }}</small>
                                                    </td>
                                                    <td class="text-center">{{ $detail->product->codigo_barra }}</td>
                                                    <td class="text-center">{{ $detail->cantidad }}</td>
                                                    <td class="text-right">S/ {{ number_format($detail->precio_unitario, 2) }}</td>
                                                    <td class="text-right amount">S/ {{ number_format($detail->cantidad * $detail->precio_unitario, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="no-data">
                                No hay ventas registradas.<br>
                                Cuando realices una venta, aparecerá en este listado.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} | Sistema de Gestión Vida Saludable
    </div>
</body>
</html>
