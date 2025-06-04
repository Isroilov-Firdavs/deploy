
@extends('layouts.app')

@section('title', 'Mokaro Users List')

@section('content')
<h2>Sotilgan tovarlar</h2>
<a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">+ Yangi sotish</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mahsulot</th>
            <th>Miqdor</th>
            <th>Narxi (bir dona)</th>
            <th>Sana</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sales as $sale)
        <tr>
            <td>{{ $sale->product->name }}</td>
            <td>{{ $sale->quantity }} {{ $sale->product->unit }}</td>
            <td>{{ number_format($sale->price_per_unit, 2) }} so'm</td>
            <td>{{ $sale->sale_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
