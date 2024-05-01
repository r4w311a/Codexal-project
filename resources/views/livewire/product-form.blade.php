<div>
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2>Products</h2>
        <button wire:click="openModal" class="btn btn-primary">Add Product</button>
    </div>
    @if ($showModal)
        <div class="modal fade show" style="display: block;" role="dialog" aria-modal="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editMode ? 'Edit Product' : 'Add New Product' }}</h5>
                        <button wire:click="closeModal" type="button" class="close">×</button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="product" wire:submit.prevent="save" enctype="multipart/form-data">
                            @csrf
                            @if ($editMode)
                                <input type="hidden" name="productId" wire:model="productId">
                            @endif
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label>Product name:</label>
                                <input type="text" id="name" name="name" value="" class="form-control"
                                    wire:model="name" placeholder="Enter Name">
                                @if ($errors->has('name'))
                                    <span class="text-red" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <br>
                            <div class="form-group {{ $errors->has('color') ? 'has-error' : '' }}">
                                <label>Product Color:</label>
                                <input type="text" id="color" name="color" value="" class="form-control"
                                    wire:model="color" placeholder="Enter Color">
                                @if ($errors->has('color'))
                                    <span class="text-red" role="alert">
                                        <strong>{{ $errors->first('color') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="imageUpload">Product Image:</label>
                                <input type="file" wire:model="image" class="form-control" id="imageUpload">
                                @error('image')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror

                            </div>
                            <br>
                            <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                                <label>Assign to category:</label>
                                <ul id="tree1">
                                    @foreach ($categories as $category)
                                        @if (!$category->parent_id)
                                            <li> <input type="radio" id="parent_id_{{ $category->id }}"
                                                    name="parent_id" value="{{ $category->id }}"
                                                    wire:model="selectedCategory"
                                                    wire:click="categorySelected({{ $category->id }})"
                                                    {{ $category->id == $selectedCategory ? 'checked' : '' }}
                                                    {{ count($category->children) > 0 ? 'disabled' : '' }}>
                                                <label
                                                    for="parent_id_{{ $category->id }}">{{ $category->name }}</label><br>

                                            </li>

                                            @if (count($category->children))
                                                @include('admin.products.manageCheckbox', [
                                                    'children' => $category->children,
                                                ])
                                            @endif
                                        @endif
                                    @endforeach

                                </ul>
                                @if ($errors->has('parent_id'))
                                    <span class="text-red" role="alert">
                                        <strong>{{ $errors->first('parent_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input type="hidden" name="parent_id" wire:model="selectedCategory">

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
