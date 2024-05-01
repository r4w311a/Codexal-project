@extends('admin.dashboard')
@section('content')
    <div class="products-container">



        <div class="mb-3">
            @livewire('product-form')
        </div>

        @livewire('product-table')


    </div>
@endsection
