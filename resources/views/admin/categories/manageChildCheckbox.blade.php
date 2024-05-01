<ul>
    @foreach ($children as $child)
        <li>
            <input type="radio" id="parent_id_{{ $child->id }}" name="parent_id"
                value="{{ $child->id }} wire:model="selectedCategory"
                wire:click="categorySelected({{ $child->id }}) {{ request()->routeIs('manage-products') && $child->children() ? 'disabled' : '' }}">
            <label for="vehicle1"> {{ $child->name }}</label><br>
            @if (count($child->children))
                @include('admin.categories.manageChildCheckbox', ['children' => $child->children])
            @endif
        </li>
    @endforeach
</ul>
