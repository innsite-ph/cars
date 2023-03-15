<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Cars::all();
        return response()-> json($cars);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'vin' => 'unique:cars',
        'license_plate'=> 'unique:cars',
        'engine_code'=> 'unique:cars',
        
        ]);
        
        $cars = new Cars();
        $cars->vin = $request->vin;
        $cars->license_plate = $request->license_plate; 
        $cars->brand = $request->brand; 
        $cars->model = $request->model;
        $cars->gearbox_type = $request->gearbox_type;
        $cars->colour = $request->colour;
        $cars->fuel_type = $request->fuel_type;
        $cars->engine_capacity = $request->engine_capacity;
        $cars->power = $request->power;
        $cars->engine_code = $request->engine_code;
        $cars->car_year = $request->car_year;
        $cars->save();  

        return response()-> json($cars);
    }   

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Cars::all()->where('id', $id);
        return response()-> json($car);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cars = Cars::find($id);
        $cars->vin = $request->vin;
        $cars->license_plate = $request->license_plate; 
        $cars->brand = $request->brand; 
        $cars->model = $request->model;
        $cars->gearbox_type = $request->gearbox_type;
        $cars->colour = $request->colour;
        $cars->fuel_type = $request->fuel_type;
        $cars->engine_capacity = $request->engine_capacity;
        $cars->power = $request->power;
        $cars->engine_code = $request->engine_code;
        $cars->car_year = $request->car_year;
        $cars->save();  

        return response()-> json($cars);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cars::destroy($id);
        return response()->json(['message' => 'Cars deleted successfully']);
    }
}
