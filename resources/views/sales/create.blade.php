
@extends('layouts.app')

@section('title', 'Mokaro Users List')

@section('content')
<h2>Yangi tovar sotish</h2>

<form method="POST" action="{{ route('sales.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Mahsulot</label>
        <select name="product_id" class="form-select" required>
            <option value="">Mahsulotni tanlang</option>
            @foreach($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->unit }})</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Miqdor</label>
        <input type="number" name="quantity" class="form-control" min="1" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Narxi (bir dona)</label>
        <input type="number" step="0.01" name="price_per_unit" class="form-control" min="0" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Sotilgan sana</label>
        <input type="date" name="sale_date" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Saqlash</button>
</form>
@endsection
