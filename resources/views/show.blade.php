@extends('layouts.app')

@section('title', 'Edit Car')

@section('content')
    <h2>Car Details</h2>

    <table class="table table-bordered">
        <tr><th>Make</th><td>{{ $car->make }}</td></tr>
        <tr><th>Model</th><td>{{ $car->model }}</td></tr>
        <tr><th>Model Year</th><td>{{ $car->model_year }}</td></tr>
        <tr><th>Car VIN</th><td>{{ $car->car_vin }}</td></tr>
    </table>

    <a href="{{ route('cars.index') }}" class="btn btn-primary">Back to List</a>
    <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-warning">Edit</a>
@endsection
