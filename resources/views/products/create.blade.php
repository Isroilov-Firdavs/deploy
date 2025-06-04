
@extends('layouts.app')

@section('title', 'Mokaro Users List')

@section('content')
<h2>Yangi mahsulot qo‘shish</h2>

<form method="POST" action="{{ route('products.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Mahsulot nomi</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Birlik (dona, kg, ltr...)</label>
        <input type="text" name="unit" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Saqlash</button>
</form>
@endsection
