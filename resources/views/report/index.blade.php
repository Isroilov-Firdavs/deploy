
@extends('layouts.app')

@section('title', 'Mokaro Users List')

@section('content')
<h2>Hisobotlar</h2>

<form method="GET" action="{{ route('report.index') }}" class="row mb-4">
    <div class="col-md-4">
        <label>Boshlang‘ich sana</label>
        <input type="date" name="start_date" value="{{ $start }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label>Oxirgi sana</label>
        <input type="date" name="end_date" value="{{ $end }}" class="form-control">
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary">Filtrlash</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mahsulot</th>
            <th>Ostatka (qoldiq)</th>
            <th>Sotilgan miqdor</th>
            <th>Sotishdan tushgan summa (so‘m)</th>
            <th>Qabul qilinishdan sarflangan summa (so‘m)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $prod)
        <tr>
            <td>{{ $prod['name'] }}</td>
            <td>{{ $prod['ostatka'] }} {{ $prod['unit'] }}</td>
            <td>{{ $prod['sold_quantity'] }} {{ $prod['unit'] }}</td>
            <td>{{ number_format($prod['total_sales'], 2) }}</td>
            <td>{{ number_format($prod['total_purchases'], 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
