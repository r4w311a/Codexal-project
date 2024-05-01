<div class="col-md-2 side-nav">
    <div class="store-name">
        Codexel </div>
    <ul class="nav flex-column nav-pills mb-auto">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }} text-white" aria-current="page" href="{{route('dashboard')}}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('categories') ? 'active' : '' }} text-white" href="{{route('manage-categories')}}">Categories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('products') ? 'active' : '' }} text-white" href="{{route('manage-products')}}">Products</a>
        </li>
    </ul>
</div>