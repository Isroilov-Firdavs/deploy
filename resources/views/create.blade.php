@extends('layouts.app')

@section('content')
    <h2>Create New Car</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Make</label>
            <input type="text" name="make" class="form-control" value="{{ old('make') }}" required>
        </div>

        <div class="mb-3">
            <label>Model</label>
            <input type="text" name="model" class="form-control" value="{{ old('model') }}" required>
        </div>

        <div class="mb-3">
            <label>Model Year</label>
            <input type="text" name="model_year" class="form-control" value="{{ old('model_year') }}" required>
        </div>

        <div class="mb-3">
            <label>Car VIN</label>
            <input type="text" name="car_vin" class="form-control" value="{{ old('car_vin') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('cars.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
