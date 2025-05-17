<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buy_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Compra_detalleController extends Controller
{
    public function index()
    {
        return view('admin.compra_detalle.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'buy_id' => 'required|exists:buys,id',
            'product_id' => 'required|exists:products,id',
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();

            $compra_detalle = Buy_detail::create([
                'buy_id' => $request->buy_id,
                'product_id' => $request->product_id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio_unitario,
            ]);

            return redirect()->route('admin.compra_detalle.index')
                ->with('success', 'El detalle compra fue registrado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'buy_id' => 'required|exists:buys,id',
            'product_id' => 'required|exists:products,id',
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();

            $compra_detalle = Buy_detail::findOrFail($id);
            $compra_detalle->update([
                'buy_id' => $request->buy_id,
                'product_id' => $request->product_id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio_unitario,
            ]);

            return redirect()->route('admin.compra_detalle.index')
                ->with('success', 'El detalle compra fue actualizado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        Buy_detail::find($id)->delete();
        return redirect()->route('admin.compra_detalle.index')->with('success', 'El detalle compra fue eliminada correctamente.');
    }
}
