<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BuysExport;
use App\Http\Controllers\Controller;
use App\Models\Buy;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class CompraController extends Controller
{
    public function index()
    {
        return view('admin.compra.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:buys,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric|min:0',
            'tipo_comprobante' => 'required|string|in:factura,boleta',
        ]);

        try {
            $validator->validate();

            $compra = Buy::create([
                //Crea la compra asignando el usur_id del usuario autenticado
                'user_id' => auth()->id(),
                'supplier_id' => $request->supplier_id,
                'fecha' => $request->fecha,
                'total' => $request->total,
                'tipo_comprobante' => $request->tipo_comprobante,
            ]);

            return redirect()->route('admin.compra.index')
                ->with('success', 'La compra fue registrado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:buys,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric|min:0',
            'tipo_comprobante' => 'required|string|in:factura,boleta',
        ]);

        try {
            $validator->validate();

            $compra = Buy::findOrFail($id);
            $compra->update([
                'user_id' => auth()->id(),
                'supplier_id' => $request->supplier_id,
                'fecha' => $request->fecha,
                'total' => $request->total,
                'tipo_comprobante' => $request->tipo_comprobante,
            ]);

            return redirect()->route('admin.compra.index')
                ->with('success', 'La compra fue actualizado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        Buy::find($id)->delete();
        return redirect()->route('admin.compra.index')->with('success', 'La compra fue eliminada correctamente.');
    }

    public function exportPdf()
    {
        $buys = Buy::orderBy('created_at', 'desc')->get();
        $pdf = Pdf::loadView('admin.compra.pdf', compact('buys'));
        return $pdf->download('reporte_compra.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new BuysExport, 'reporte_compras.xlsx');
    }
}
