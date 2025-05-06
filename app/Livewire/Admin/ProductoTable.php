<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;

class ProductoTable extends Component
{
    public function render()
    {
        $products = Product::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('livewire.admin.producto-table', compact('products', 'categories', 'suppliers'));
    }
}
