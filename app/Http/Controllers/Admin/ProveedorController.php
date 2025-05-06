<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProveedorController extends Controller
{
    public function index()
    {
        return view('admin.proveedor.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ruc' => 'required|digits:11|',
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|digits:9',
            'email' => 'required|email|max:255|',
        ]);

        try {
            $validator->validate();

            $supplier = Supplier::create([
                'ruc' => $request->ruc,
                'razon_social' => $request->razon_social,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'status' => true // Por defecto activo
            ]);

            return redirect()->route('admin.proveedor.index')
                ->with('success', 'El proveedor fue registrado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'ruc' => 'required|digits:11|',
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|digits:9',
            'email' => 'required|email|max:255|',
        ]);

        try {
            $validator->validate();

            $supplier = Supplier::findOrFail($id);
            $supplier->update([
                'ruc' => $request->ruc,
                'razon_social' => $request->razon_social,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'email' => $request->email,
            ]);

            return redirect()->route('admin.proveedor.index')
                ->with('success', 'El proveedor fue actualizado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update(['status' => false]);

        return redirect()->route('admin.proveedor.index')
            ->with('success', 'El proveedor fue eliminado correctamente.');
    }
}
