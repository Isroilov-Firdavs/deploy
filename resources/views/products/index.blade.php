
@extends('layouts.app')

@section('title', 'Mokaro Users List')

@section('content')
<h2>Mahsulotlar</h2>
<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">+ Yangi mahsulot</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nomi</th>
            <th>Birlik</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->unit }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
    {{ $products->links() }}
</div>
@endsection
