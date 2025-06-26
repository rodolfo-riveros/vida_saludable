<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Product::with(['category', 'supplier'])
            ->where('status', true)
            ->select(
                'id',
                'category_id',
                'supplier_id',
                'name',
                'description',
                'codigo_barra',
                'precio_venta',
                'precio_compra',
                'stock',
                'stock_minimo',
                'status'
            )
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'category_name' => $item->category->name ?? 'N/A',
                    'supplier_name' => $item->supplier->razon_social ?? 'N/A',
                    'name' => $item->name,
                    'description' => $item->description,
                    'codigo_barra' => $item->codigo_barra,
                    'precio_venta' => $item->precio_venta,
                    'precio_compra' => $item->precio_compra,
                    'stock' => $item->stock,
                    'stock_minimo' => $item->stock_minimo,
                    'status' => $item->status ? 'Activo' : 'Inactivo'
                ];
            });
    }

    public function headings(): array
    {
        return [
            '#',
            'Categoría',
            'Proveedor',
            'Nombre',
            'Descripción',
            'Código de Barra',
            'Precio Venta',
            'Precio Compra',
            'Stock Actual',
            'Stock Mínimo',
            'Estado'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Autoajustar el ancho de las columnas A-K
        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [
            // Estilo para el encabezado
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']]
            ],
            // Bordes para toda la tabla (ajusta 'K' según el número de columnas)
            'A1:K' . ($sheet->getHighestRow()) => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ]
            ],
        ];
    }
}
