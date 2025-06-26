<?php

namespace App\Exports;

use App\Models\Buy_detail;
use App\Models\Buy;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Buy_detailsExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        // Cargamos las relaciones de compra y producto
        return Buy_detail::with(['buy', 'product'])
            ->select(
                'id',
                'buy_id',
                'product_id',
                'cantidad',
                'precio_unitario'
            )
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'buy_id_display' => $item->buy->id ?? 'N/A', // ID de la compra a la que pertenece
                    'product_name' => $item->product->name ?? 'N/A', // Nombre del producto
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->precio_unitario,
                    'subtotal' => $item->cantidad * $item->precio_unitario, // Calculamos el subtotal
                ];
            });
    }

    public function headings(): array
    {
        return [
            '#',
            'ID Compra',
            'Producto',
            'Cantidad',
            'Precio Unitario',
            'Subtotal',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Autoajustar el ancho de las columnas A-F
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [
            // Estilo para el encabezado
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']]
            ],
            // Bordes para toda la tabla (ajusta 'F' según el número de columnas)
            'A1:F' . ($sheet->getHighestRow()) => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ]
            ],
        ];
    }
}
