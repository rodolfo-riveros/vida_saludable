<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ProductoController extends Controller
{
    public function index()
    {
        return view('admin.producto.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'codigo_barra' => 'required|string|unique:products,codigo_barra',
            'precio_venta' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
        ]);

        try {
            $validator->validate();

            $product = Product::create([
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'name' => $request->name,
                'description' => $request->description,
                'codigo_barra' => $request->codigo_barra,
                'precio_venta' => $request->precio_venta,
                'precio_compra' => $request->precio_compra,
                'stock' => $request->stock,
                'stock_minimo' => $request->stock_minimo,
                'status' => true, // Por defecto activo
            ]);

            return redirect()->route('admin.producto.index')
                ->with('success', 'El producto fue registrado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'codigo_barra' => 'required|string|unique:products,codigo_barra',
            'precio_venta' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
        ]);

        try {
            $validator->validate();

            $product = Product::findOrFail($id);
            $product->update([
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'name' => $request->name,
                'description' => $request->description,
                'codigo_barra' => $request->codigo_barra,
                'precio_venta' => $request->precio_venta,
                'precio_compra' => $request->precio_compra,
                'stock' => $request->stock,
                'stock_minimo' => $request->stock_minimo,
            ]);

            return redirect()->route('admin.producto.index')
                ->with('success', 'El producto fue actualizado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => false]);

        return redirect()->route('admin.producto.index')
            ->with('success', 'El producto fue eliminado correctamente.');
    }

    public function exportPdf()
    {
        $products = Product::where('status', true)->get();
        $pdf = Pdf::loadView('admin.producto.pdf', compact('products'));
        return $pdf->download('reporte_producto.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'reporte_productos.xlsx');
    }
}
