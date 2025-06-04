
@extends('layouts.app')

@section('title', 'Mokaro Users List')

@section('content')
<h2>Qabul qilingan tovarlar</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Mahsulot</th>
                <th>Miqdori</th>
                <th>Bir dona narxi (so'm)</th>
                <th>Jami (so'm)</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($purchases as $key => $purchase)
                @php
                    $sum = $purchase->quantity * $purchase->price_per_unit;
                    $total += $sum;
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $purchase->product->name }}</td>
                    <td>{{ $purchase->quantity }} {{ $purchase->product->unit }}</td>
                    <td>{{ number_format($purchase->price_per_unit, 0, ',', ' ') }}</td>
                    <td>{{ number_format($sum, 0, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Umumiy summa:</th>
                <th>{{ number_format($total, 0, ',', ' ') }} so'm</th>
            </tr>
        </tfoot>
    </table>
@endsection
