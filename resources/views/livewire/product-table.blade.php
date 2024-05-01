<div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Picture</th>
                    <th>Color</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            @if ($product->picture)
                                <img src="{{ asset('storage/products_images/' . $product->picture) }}" alt="product Image"
                                    style="max-height: 50px;">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $product->color }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                            <button wire:click="edit({{ $product->id }})">Edit</button>
                            <button wire:click="delete({{ $product->id }})">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white">
                        <td colspan="3" class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            No products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
