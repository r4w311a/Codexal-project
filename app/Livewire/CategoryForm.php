<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class CategoryForm extends Component
{
    public $showModal = false;
    public $editMode = false;

    public $name, $image, $categoryId, $selectedCategory, $parent_id;


    use WithFileUploads;


    protected $listeners = [
        'setEditMode' => 'prepareForEdit'
    ];

    public function openModal()
    {
        $this->reset('name'); // Clear input on open
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

        return view('livewire.category-form', [
            'categories' => $categories
        ]);

    }
    public function categorySelected($categoryId)
    {

        if ($categoryId === null) {
            $this->selectedCategory = null;  // Represent "TOP-LEVEL"
        } else {
            $this->selectedCategory = $categoryId;
        }
    }
    public function save()
    {

        $this->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $categoryData = [
            'name' => $this->name,
            'parent_id' => $this->selectedCategory,
        ];

        if ($this->editMode) {
            $category = Category::findOrFail($this->categoryId);

            if ($this->image) {
                if ($category->picture) {
                    Storage::disk('public')->delete('category_images/' . $category->picture);
                }

                $imageName = time() . '.' . $this->image->extension();
                $this->image->storeAs('public/category_images', $imageName);
                $categoryData['picture'] = $imageName;
            }

            $category->update($categoryData);
        } else {
            if ($this->image) {
                $imageName = time() . '.' . $this->image->extension();
                $this->image->storeAs('public/category_images', $imageName);
                $categoryData['picture'] = $imageName;
            }

            Category::create($categoryData);
        }
        $this->reset('name', 'image', 'selectedCategory');
        $this->closeModal();
        $this->dispatch('refreshCategories');
    }
    public function refreshCategories()
    {
        $this->categories = Category::with('children')->get();
    }

    public function prepareForEdit($data)
    {
        $this->categoryId = $data['id'];
        $this->name = $data['name'];
        $this->selectedCategory = $data['parentId'];
        $this->editMode = true;
        $this->showModal = true;
    }


}
