<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuppliersExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Supplier::where('status', true)
            ->select('id', 'ruc', 'razon_social', 'direccion', 'telefono', 'email', 'status')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'ruc' => $item->ruc,
                    'razon_social' => $item->razon_social,
                    'direccion' => $item->direccion,
                    'telefono' => $item->telefono,
                    'email' => $item->email,
                    'status' => $item->status ? 'Activo' : 'Inactivo'
                ];
            });
    }

    public function headings(): array
    {
        return [
            '#',
            'RUC',
            'Razón Social',
            'Dirección',
            'Teléfono',
            'Email',
            'Estado'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Autoajustar el ancho de las columnas A-G
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [
            // Estilo para el encabezado
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']]
            ],
            // Bordes para toda la tabla (ajusta 'G' según el número de columnas)
            'A1:G' . ($sheet->getHighestRow()) => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ]
            ],
        ];
    }
}
