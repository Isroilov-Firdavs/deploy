<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('model_year', 'like', "%{$search}%")
                  ->orWhere('car_vin', 'like', "%{$search}%");
        }
        $query->orderBy('id', 'desc');

        $cars = $query->paginate(10);

        return view('index', compact('cars'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'model_year' => 'required|string|max:255',
            'car_vin' => 'required|string|max:255|unique:cars,car_vin',
        ]);

        Car::create($request->all());

        return redirect()->route('cars.index')->with('success', 'Car created successfully.');
    }

    public function show(Car $car)
    {
        return view('show', compact('car'));
    }

    public function edit(Car $car)
    {
        return view('edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'model_year' => 'required|digits:4|integer',
            'car_vin' => 'required|string|max:255|unique:cars,car_vin,' . $car->id,
        ]);

        $car->update($request->all());

        return redirect()->route('cars.index')->with('success', 'Car updated successfully.');
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Car deleted successfully.');
    }

}
