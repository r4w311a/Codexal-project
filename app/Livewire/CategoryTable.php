<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryTable extends Component
{
    protected $listeners = ['refreshCategories' => 'refreshData'];

    public function refreshData()
    {
        $this->categories = Category::where('parent_id', null)->get();

    }

    public function render()
    {
        $categories = Category::with('children')->get();

        return view('livewire.category-table', [
            'categories' => $categories
        ]);
    }

    public function edit($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $this->dispatch('setEditMode', [
            'id' => $category->id,
            'name' => $category->name,
            'parentId' => $category->parent_id
        ]);
    }

    public function delete($categoryId)
    {
        $category = Category::with('children')->findOrFail($categoryId);

        if ($category->children->count() > 0) {
            foreach ($category->children as $child) {
                $this->delete($child->id); // Recursive call
            }
        }
        $category->delete();
        $this->dispatch('refreshData');

    }
}
