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
        return Car::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_name' => 'required|string|max:50',
            'day_rate' => 'required|numeric',
            'month_rate' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048', // validasi file
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
        }

        $car = Car::create([
            'car_name' => $request->car_name,
            'day_rate' => $request->day_rate,
            'month_rate' => $request->month_rate,
            'image' => $imagePath,
        ]);

        return response()->json($car, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Car::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $request->validate([
            'car_name' => 'sometimes|string|max:50',
            'day_rate' => 'sometimes|numeric',
            'month_rate' => 'sometimes|numeric',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
            $car->image = $imagePath;
        }

        $car->update($request->only(['car_name', 'day_rate', 'month_rate']));
        $car->save();

        return response()->json($car);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Car::destroy($id);
    }
}
