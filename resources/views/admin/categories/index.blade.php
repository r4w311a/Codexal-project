@extends('admin.dashboard')
@section('content')
    <div class="categories-container">



        <div class="mb-3">
            @livewire('category-form')
        </div>

        @livewire('category-table')


    </div>
@endsection
