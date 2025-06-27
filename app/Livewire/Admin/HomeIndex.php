<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use Livewire\Component;
use App\Models\Sale;
use App\Models\Sale_detail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeIndex extends Component
{
    public $latestSales;
    public $totalCustomers;
    public $newCustomersThisMonth;
    public $customerGrowthPercentage;
    public $totalSalesThisMonth;
    public $salesGrowthPercentage;
    public $formattedTotalSales;
    public $mostSoldProduct;
    public $leastSoldProduct;
    public $lastThreeMonthsSales;

    public function mount()
    {
        $this->loadLatestSales();
        $this->loadCustomerStats();
        $this->loadSalesStats();
        $this->loadProductStats();
        $this->loadLastThreeMonthsSales();
    }

    protected function loadLatestSales()
    {
        $this->latestSales = Sale::with(['customer', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($sale) {
                return [
                    'id' => $sale->id,
                    'customer_name' => $sale->customer->nombres ?? 'Cliente eliminado',
                    'user_name' => $sale->user->name,
                    'total' => $sale->total,
                    'fecha' => $sale->fecha,
                    'time_ago' => Carbon::parse($sale->fecha)->diffForHumans(),
                    'tipo_comprobante' => $sale->tipo_comprobante
                ];
            });
    }

    protected function loadCustomerStats()
    {
        // Total de clientes registrados
        $this->totalCustomers = Customer::count();

        // Clientes registrados en el último mes
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $this->newCustomersThisMonth = Customer::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        // Cálculo de crecimiento porcentual (opcional)
        $lastMonthCount = Customer::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();

        $this->customerGrowthPercentage = $lastMonthCount > 0
            ? round(($this->newCustomersThisMonth - $lastMonthCount) / $lastMonthCount * 100)
            : 100;
    }

    protected function loadSalesStats()
    {
        // Obtener fechas para el mes actual
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Sumar todas las ventas del mes actual
        $this->totalSalesThisMonth = Sale::whereBetween('fecha', [$startOfMonth, $endOfMonth])
            ->sum('total');

        // Formatear el total para mostrarlo con 2 decimales
        $this->formattedTotalSales = number_format($this->totalSalesThisMonth, 2);

        // Calcular crecimiento comparado con el mes anterior
        $lastMonthSales = Sale::whereBetween('fecha', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->sum('total');

        // Calcular porcentaje de crecimiento
        $this->salesGrowthPercentage = $lastMonthSales > 0
            ? round(($this->totalSalesThisMonth - $lastMonthSales) / $lastMonthSales * 100, 1)
            : ($this->totalSalesThisMonth > 0 ? 100 : 0);
    }

    protected function loadProductStats()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Obtener productos más y menos vendidos
        $products = Sale_detail::with(['product.category', 'sale'])
            ->whereHas('sale', function($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('fecha', [$startOfMonth, $endOfMonth]);
            })
            ->select('product_id', DB::raw('SUM(cantidad) as total_quantity'))
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->get();

        if ($products->count() > 0) {
            // Producto más vendido
            $this->mostSoldProduct = [
                'name' => $products->first()->product->name ?? 'Producto no disponible',
                'category' => $products->first()->product->category->name ?? 'Sin categoría',
                'quantity' => $products->first()->total_quantity,
                'image' => $products->first()->product->image_url ?? null
            ];

            // Producto menos vendido
            $this->leastSoldProduct = [
                'name' => $products->last()->product->name ?? 'Producto no disponible',
                'category' => $products->last()->product->category->name ?? 'Sin categoría',
                'quantity' => $products->last()->total_quantity,
                'image' => $products->last()->product->image_url ?? null
            ];
        } else {
            $this->mostSoldProduct = null;
            $this->leastSoldProduct = null;
        }
    }

    protected function loadLastThreeMonthsSales()
    {
        // Get the current month and the two previous months
        $months = [
            Carbon::now()->subMonths(2)->startOfMonth(), // Two months ago
            Carbon::now()->subMonths(1)->startOfMonth(), // One month ago
            Carbon::now()->startOfMonth(),               // Current month
        ];

        $this->lastThreeMonthsSales = collect($months)->map(function ($startDate) {
            $endDate = $startDate->copy()->endOfMonth();
            $total = Sale::whereBetween('fecha', [$startDate, $endDate])
                ->sum('total');
            return [
                'month' => $startDate->format('M'), // Short month name (e.g., Apr, May, Jun)
                'total' => round($total / 1000, 2), // Convert to thousands for chart
            ];
        })->toArray();

        $this->dispatch('salesDataUpdated', ['lastThreeMonthsSales' => $this->lastThreeMonthsSales]);
    }


    public function render()
    {
        return view('livewire.admin.home-index');
    }
}
