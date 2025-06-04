<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Car::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        $request->validate([
            'make' => 'required',
            'model' => 'required',
            'model_year' => 'required|integer',
            'car_vin' => 'required|unique:cars',
        ]);

        return Car::create($request->all());
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'make' => 'required',
            'model' => 'required',
            'model_year' => 'required|integer',
            'car_vin' => 'required|unique:cars,car_vin,' . $car->id,
        ]);

        $car->update($request->all());
        return $car;
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return response()->noContent();
    }
}
