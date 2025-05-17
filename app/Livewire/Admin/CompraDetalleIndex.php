<?php

namespace App\Livewire\Admin;

use App\Models\Buy;
use App\Models\Product;
use Livewire\Component;

class CompraDetalleIndex extends Component
{
    public function render()
    {
        $buys = Buy::all();
        $products = Product::all();
        return view('livewire.admin.compra-detalle-index', compact('buys', 'products'));
    }
}
