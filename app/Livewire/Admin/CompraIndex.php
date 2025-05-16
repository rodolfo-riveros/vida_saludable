<?php

namespace App\Livewire\Admin;

use App\Models\Supplier;
use Livewire\Component;

class CompraIndex extends Component
{
    public function render()
    {
        $suppliers = Supplier::all();
        return view('livewire.admin.compra-index', compact('suppliers'));
    }
}
