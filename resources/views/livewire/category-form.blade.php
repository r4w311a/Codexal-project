<div>
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2>Categories</h2>
        <button wire:click="openModal" class="btn btn-primary">Add Category</button>
    </div>
    @if ($showModal)
        <div class="modal fade show" style="display: block;" role="dialog" aria-modal="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editMode ? 'Edit Category' : 'Add New Category' }}</h5>
                        <button wire:click="closeModal" type="button" class="close">×</button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="category" wire:submit.prevent="save" enctype="multipart/form-data">
                            @csrf
                            @if ($editMode)
                                <input type="hidden" name="categoryId" wire:model="categoryId">
                            @endif
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label>Category name:</label>
                                <input type="text" id="name" name="name" value="" class="form-control"
                                    wire:model="name" placeholder="Enter Name">
                                @if ($errors->has('name'))
                                    <span class="text-red" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="imageUpload">Category Image:</label>
                                <input type="file" wire:model="image" class="form-control" id="imageUpload">
                                @error('image')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror

                            </div>
                            <br>
                            <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">

                                <input type="radio" id="top-level" name="parent_id">
                                <label for="top-level">TOP-LEVEL
                                    CATEGORY</label><br>
                                <label>Assign as a sub category:</label>
                                <ul id="tree1">
                                    @foreach ($categories as $category)
                                        @if (!$category->parent_id)
                                            <li> <input type="radio" id="parent_id_{{ $category->id }}"
                                                    name="parent_id" value="{{ $category->id }}"
                                                    wire:model="selectedCategory"
                                                    wire:click="categorySelected({{ $category->id }})"
                                                    {{ $category->id == $selectedCategory ? 'checked' : '' }}>
                                                <label
                                                    for="parent_id_{{ $category->id }}">{{ $category->name }}</label><br>

                                            </li>

                                            @if (count($category->children))
                                                @include('admin.categories.manageCheckbox', [
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
