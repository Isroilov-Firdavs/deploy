@extends('layouts.app')

@section('content')
    <h2>Edit Car</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.update', $car->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Make</label>
            <input type="text" name="make" class="form-control" value="{{ old('make', $car->make) }}" required>
        </div>

        <div class="mb-3">
            <label>Model</label>
            <input type="text" name="model" class="form-control" value="{{ old('model', $car->model) }}" required>
        </div>

        <div class="mb-3">
            <label>Model Year</label>
            <input type="number" name="model_year" class="form-control" value="{{ old('model_year', $car->model_year) }}" required>
        </div>

        <div class="mb-3">
            <label>Car VIN</label>
            <input type="text" name="car_vin" class="form-control" value="{{ old('car_vin', $car->car_vin) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('cars.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
