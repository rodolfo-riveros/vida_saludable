<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Supplier;
use Livewire\Component;

class ProductoIndex extends Component
{
    public function render()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('livewire.admin.producto-index', compact('categories', 'suppliers'));
    }
}
