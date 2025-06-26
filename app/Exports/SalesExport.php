<?php

namespace App\Exports;

use App\Models\Sale_detail; // Cambiamos a Sale_detail como base
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        // Cargamos las relaciones anidadas: sale.user, sale.customer y product
        return Sale_detail::with(['sale.user', 'sale.customer', 'product'])
            ->get()
            ->map(function ($detail) {
                // Accedemos a la información de la venta padre
                $sale = $detail->sale;
                // Accedemos a la información del producto
                $product = $detail->product;

                return [
                    'sale_id' => $sale->id ?? 'N/A',
                    'user_name' => $sale->user->name ?? 'N/A', // Nombre del usuario que realizó la venta
                    'customer_name' => ($sale->customer->nombres ?? '') . ' ' . ($sale->customer->apellidos ?? ''), // Nombre completo del cliente
                    'fecha_venta' => $sale->fecha ?? 'N/A',
                    'tipo_comprobante' => $sale->tipo_comprobante ?? 'N/A',
                    'total_venta' => $sale->total ?? 'N/A', // Total de toda la venta
                    'subtotal_venta' => $sale->subtotal ?? 'N/A', // Subtotal de toda la venta
                    'igv_venta' => $sale->igv ?? 'N/A', // IGV de toda la venta
                    'product_name' => $product->name ?? 'N/A',
                    'cantidad' => $detail->cantidad,
                    'precio_unitario' => $detail->precio_unitario,
                    'subtotal_detalle' => $detail->cantidad * $detail->precio_unitario, // Subtotal por línea de detalle
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID Venta',
            'Usuario',
            'Cliente',
            'Fecha Venta',
            'Tipo Comprobante',
            'Total Venta',
            'Subtotal Venta (General)',
            'IGV Venta (General)',
            'Producto',
            'Cantidad',
            'Precio Unitario',
            'Subtotal Detalle',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Autoajustar el ancho de las columnas A-L (12 columnas)
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [
            // Estilo para el encabezado
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']]
            ],
            // Bordes para toda la tabla (hasta la columna L)
            'A1:L' . ($sheet->getHighestRow()) => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ]
            ],
        ];
    }
}
