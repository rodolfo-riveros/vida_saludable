<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Sale_detail;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use App\Notifications\LowStockNotification;

class VentaController extends Controller
{
    public function index()
    {
        return view('admin.venta.index');
    }

    public function getProduct(Request $request)
    {
        $barcode = $request->input('codigo_barra');
        $product = Product::where('codigo_barra', $barcode)
            ->where('status', true)
            ->first();

        if ($product) {
            return response()->json(['product' => $product]);
        } else {
            return response()->json(['error' => 'Producto no encontrado o no está activo'], 404);
        }
    }

    public function getCustomer(Request $request)
    {
        $numeroDocumento = $request->input('numero_documento');
        $customer = Customer::select('id', 'nombres', 'apellidos')
            ->where('numero_documento', $numeroDocumento)
            ->first();

        if ($customer) {
            return response()->json([
                'id' => $customer->id,
                'nombres' => $customer->nombres,
                'apellidos' => $customer->apellidos,
            ]);
        } else {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'tipo_comprobante' => 'required|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.codigo_barra' => 'required|string|exists:products,codigo_barra',
            'products.*.quantity' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();

            // Iniciar una transacción
            DB::beginTransaction();

            // Obtener usuario logueado
            $userId = Auth::id();

            // Calcular subtotal e IGV
            $total = $request->total;
            $subtotal = $total / 1.18;
            $igv = $total - $subtotal;

            // Obtener fecha actual
            $fecha = Carbon::now()->toDateString();

            // Crear la venta (tabla sales)
            $sale = Sale::create([
                'user_id' => $userId,
                'customer_id' => $request->customer_id,
                'fecha' => $fecha,
                'total' => $total,
                'tipo_comprobante' => $request->tipo_comprobante,
                'igv' => round($igv, 2),
                'subtotal' => round($subtotal, 2),
            ]);

            // Preparar datos para inserción en lote en sale_details
            $saleDetailsData = [];
            $productsToUpdate = [];

            foreach ($request->products as $item) {
                $product = Product::where('codigo_barra', $item['codigo_barra'])
                    ->where('status', true)
                    ->first();

                if (!$product) {
                    throw ValidationException::withMessages([
                        'products' => "Producto con código {$item['codigo_barra']} no encontrado o no está activo.",
                    ]);
                }

                if ($product->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'products' => "Stock insuficiente para el producto {$product->name}.",
                    ]);
                }

                // Preparar datos para sale_details
                $saleDetailsData[] = [
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'cantidad' => $item['quantity'],
                    'precio_unitario' => $product->precio_venta,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Preparar actualización de stock
                $productsToUpdate[$product->id] = [
                    'quantity' => $item['quantity'],
                    'product' => $product,
                ];
            }

            // Insertar todos los detalles de la venta en lote
            Sale_detail::insert($saleDetailsData);

            // Actualizar el stock de los productos y verificar stock mínimo
            foreach ($productsToUpdate as $productId => $data) {
                $product = $data['product'];
                $quantity = $data['quantity'];

                // Decrementar stock
                Product::where('id', $productId)
                    ->decrement('stock', $quantity);

                // Refrescar el modelo para obtener el stock actualizado
                $product->refresh();

                // Verificar si el stock está en o por debajo del mínimo
                if ($product->stock <= $product->stock_minimo) {
                    // Enviar notificación al usuario logueado
                    Auth::user()->notify(new LowStockNotification($product));
                }
            }

            // Confirmar la transacción
            DB::commit();

            // Redirigir a la ruta de impresión con el ID de la venta
            return redirect()->route('admin.venta.imprimir_boleta', ['sale' => $sale->id])
                ->with('success', 'La venta fue registrada correctamente.');
        } catch (ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al registrar la venta: ' . $e->getMessage()])->withInput();
        }
    }
}
