<div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Picture</th>
                    <th>Parent Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if ($category->picture)
                                <img src="{{ asset('storage/category_images/' . $category->picture) }}"
                                    alt="Category Image" style="max-height: 50px;">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $category->parent ? $category->parent->name : '-' }}</td>
                        <td>
                            <button wire:click="edit({{ $category->id }})">Edit</button>
                            <button wire:click="delete({{ $category->id }})">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white">
                        <td colspan="3" class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            No categories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
