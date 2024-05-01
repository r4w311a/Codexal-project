<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class ProductForm extends Component
{
    public $showModal = false;
    public $name, $image, $category_id, $selectedCategory, $productId, $color;
    public $editMode = false;
    use WithFileUploads;


    protected $listeners = [
        'setEditMode' => 'prepareForEdit'
    ];

    public function openModal()
    {
        $this->reset('name', 'color', 'selectedCategory'); // Clear input on open
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
        $this->editMode = false;

    }
    public function render()
    {
        $categories = Category::all();

        return view('livewire.product-form', [
            'categories' => $categories
        ]);
    }
    public function categorySelected($categoryId)
    {

        $this->selectedCategory = $categoryId;
    }
    public function save()
    {

        $this->validate([
            'name' => 'required|string|max:255',
            /*             'category_id' => 'required|exists:categories,id',
             */ 'color' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $productData = [
            'name' => $this->name,
            'color' => $this->color,
            'category_id' => $this->selectedCategory,
        ];

        if ($this->editMode) {
            $product = Product::findOrFail($this->productId); // Use Product model

            if ($this->image) {
                if ($product->picture) {
                    Storage::disk('public')->delete('products_images/' . $product->picture);
                }

                $imageName = time() . '.' . $this->image->extension();
                $this->image->storeAs('public/products_images', $imageName);
                $productData['picture'] = $imageName;
            }

            $product->update($productData);
        } else {
            if ($this->image) {
                $imageName = time() . '.' . $this->image->extension();
                $this->image->storeAs('public/products_images', $imageName);
                $productData['picture'] = $imageName;
            }

            Product::create($productData);
        }
        $this->reset('name', 'image', 'selectedCategory');
        $this->closeModal();
        $this->dispatch('refreshProducts');
    }
    public function refreshProducts()
    {
        $this->products = Product::with('category')->get();
    }

    public function prepareForEdit($data)
    {
        $this->ProductId = $data['id'];
        $this->name = $data['name'];
        $this->color = $data['color'];
        $this->selectedCategory = $data['category_id'];
        $this->editMode = true;
        $this->showModal = true;
    }
}
