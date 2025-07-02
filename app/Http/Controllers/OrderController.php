<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::with('car')->get();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,car_id',
            'order_date' => 'required|date',
            'pickup_date' => 'required|date',
            'dropoff_date' => 'required|date',
            'pickup_location' => 'required|string|max:50',
            'dropoff_location' => 'required|string|max:50',
        ]);

        return Order::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Order::with('car')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return $order;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Order::destroy($id);
    }
}
