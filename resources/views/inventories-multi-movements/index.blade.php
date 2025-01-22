@extends('layouts.app')
@section('content')
    <div class="row">
        @include('inventories-multi-movements.search')
        
        <div class="col-md-6">
            <div class="row">
                <div class="col">
                    @include('inventories-multi-movements.products-table')
                </div>
            </div>
            <div class="row">
                <div class="col">
                    @include('inventories-multi-movements.actions')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #table-cart-content {
            height: 80vh;
        }
    </style>
@endpush
