<?php

namespace App\Livewire\Admin;

use App\Models\Buy;
use App\Models\Buy_detail;
use App\Models\Product;
use Livewire\Component;

class CompraDetalleTable extends Component
{
    public function render()
    {
        $buyDetails = Buy_detail::orderBy('created_at', 'desc')
        ->paginate(10);
        $buys = Buy::all();
        $products = Product::all();
        return view('livewire.admin.compra-detalle-table', compact('buyDetails', 'buys', 'products'));
    }
}
