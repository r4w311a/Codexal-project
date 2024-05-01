<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductTable extends Component
{
    public $products;

    protected $listeners = ['refreshProducts' => 'refreshData'];

    public function refreshData()
    {
        $this->products = Product::all();

    }

    public function mount()
    {
        $this->products = Product::all();
    }

    public function render()
    {
        $products = Product::with('category')->get();

        return view('livewire.product-table', [
            'products' => $products
        ]);
    }

    public function delete($id)
    {
        Product::find($id)->delete();

        $this->dispatch('refreshProducts');
    }

    // edit
    public function edit($productId)
    {
        $product = Product::findOrFail($productId);

        $this->dispatch('setEditMode', [
            'id' => $product->id,
            'name' => $product->name,
            'color' => $product->color,
            'category_id' => $product->category_id
        ]);
    }

}
