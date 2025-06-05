
@extends('layouts.app')

@section('title', 'Cars List')

@section('content')
<div class="d-flex justify-content-between mb-3">
        <h2>Cars List</h2>
        <a href="{{ route('cars.create') }}" class="btn btn-primary">Create</a>
    </div>

    <form method="GET" action="{{ route('cars.index') }}" class="mb-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="form-control" />
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Make</th>
                <th>Model</th>
                <th>Model Year</th>
                <th>Car VIN</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cars as $car)
                <tr>
                    <td>{{ $car->make }}</td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->model_year }}</td>
                    <td>{{ $car->car_vin }}</td>
                    <td>
                        <a href="{{ route('cars.show', $car->id) }}" class="btn btn-info btn-sm">View</a>

                        <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>

                        <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No cars found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $cars->withQueryString()->links() }}
@endsection
