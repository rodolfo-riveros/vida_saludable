<?php

namespace App\Exports;

use App\Models\Buy;
use App\Models\User; // Asegúrate de importar el modelo User
use App\Models\Supplier; // Asegúrate de importar el modelo Supplier
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BuysExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Buy::with(['user', 'supplier']) // Cargamos las relaciones de usuario y proveedor
            ->select(
                'id',
                'user_id',
                'supplier_id',
                'fecha',
                'total',
                'tipo_comprobante'
            )
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'user_name' => $item->user->name ?? 'N/A', // Nombre del usuario
                    'supplier_razon_social' => $item->supplier->razon_social ?? 'N/A', // Razón social del proveedor
                    'fecha' => $item->fecha,
                    'total' => $item->total,
                    'tipo_comprobante' => $item->tipo_comprobante,
                ];
            });
    }

    public function headings(): array
    {
        return [
            '#',
            'Usuario',
            'Proveedor',
            'Fecha',
            'Total',
            'Tipo de Comprobante',
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
