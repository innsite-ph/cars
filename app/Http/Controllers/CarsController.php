<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\CarRequest;
use Illuminate\Support\Facades\DB;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $results = Cars::when($request->input('query'), function ($query, $input) {
            return $query->where('brand', 'like', '%' . $input . '%')
                ->orWhere('colour', 'like', '%' . $input . '%')
                ->orWhere('model', 'like', '%' . $input . '%')
                ->orWhere('vin', 'like', '%' . $input . '%')
                ->orWhere('license_plate', 'like', '%' . $input . '%')
                ->orWhere('gearbox_type', 'like', '%' . $input . '%')
                ->orWhere('fuel_type', 'like', '%' . $input . '%')
                ->orWhere('engine_capacity', 'like', '%' . $input . '%')
                ->orWhere('power', 'like', '%' . $input . '%')
                ->orWhere('car_year', 'like', '%' . $input . '%');
        })->paginate(5);
        return response()->json($results);
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
    public function store(CarRequest $request)
    {
        $cars = Cars::create($request->validated());
        // $cars = new Cars();
        // $cars->vin = $request->vin;
        // $cars->license_plate = $request->license_plate;
        // $cars->brand = $request->brand;
        // $cars->model = $request->model;
        // $cars->gearbox_type = $request->gearbox_type;
        // $cars->colour = $request->colour;
        // $cars->fuel_type = $request->fuel_type;
        // $cars->engine_capacity = $request->engine_capacity;
        // $cars->power = $request->power;
        // $cars->engine_code = $request->engine_code;
        // $cars->car_year = $request->car_year;
        // $cars->save();

        return response()->json($cars);


        return response()->json($cars);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Cars::all()->where('id', $id);
        return response()->json($car);
        return response()->json($car);

        return response()->json($car);
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

        return response()->json($cars);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cars::destroy($id);
        return response()->json(['message' => 'Cars deleted successfully']);
    }

    public function search_car(Request $request)
    {
        $car = "%" . $request->input("car") . "%";
        $checkInDate = $request->input("checkInDate");
        $checkOutDate = $request->input("checkOutDate");
        // $ids = [];
        // $cars = Cars::select('brand', 'id', 'colour', 'model', 'power', 'fuel_type', 'license_plate', 'car_year')->where('brand', 'like', '%' . $car . '%')
        //     ->orWhere('colour', 'like', '%' . $car . '%')
        //     ->orWhere('model', 'like', '%' . $car . '%')
        //     ->orWhere('vin', 'like', '%' . $car . '%')
        //     ->orWhere('license_plate', 'like', '%' . $car . '%')
        //     ->orWhere('gearbox_type', 'like', '%' . $car . '%')
        //     ->orWhere('fuel_type', 'like', '%' . $car . '%')
        //     ->orWhere('engine_capacity', 'like', '%' . $car . '%')
        //     ->orWhere('power', 'like', '%' . $car . '%')
        //     ->orWhere('car_year', 'like', '%' . $car . '%')->get();
        // $reservations = Reservation::select('check_in_date', 'check_out_date', 'car_id')->get();
        // for ($c = 0; $c < count($cars); $c++) {
        //     $not_available = true;
        //     for ($r = 0; $r < count($reservations); $r++) {
        //         // CHECK IF RESERVATION IS FOR THE CAR
        //         if ($reservations[$r]['car_id'] == $cars[$c]['id']) {
        //             // CHECK IF CAR IS ALREADY INSIDE IDS
        //             if (!in_array($cars[$c]['id'], $ids)) {
        //                 if ($checkInDate > strtotime($reservations[$r]['check_in_date']) && $checkInDate < strtotime($reservations[$r]['check_out_date'])) {
        //                     array_push($ids, array('car_id' => $cars[$c]['id'], 'not_available' => true, 'car_year' => $cars[$c]['car_year'], 'license_plate' => $cars[$c]['license_plate'], 'fuel_type' => $cars[$c]['fuel_type'], 'power' => $cars[$c]['power'], 'model' => $cars[$c]['model'], 'colour' => $cars[$c]['colour'], 'brand' => $cars[$c]['brand']));
        //                     $not_available = false;
        //                     break;
        //                 } else if ($checkOutDate > strtotime($reservations[$r]['check_in_date']) && $checkOutDate < strtotime($reservations[$r]['check_out_date'])) {
        //                     array_push($ids, array('car_id' => $cars[$c]['id'], 'not_available' => true, 'car_year' => $cars[$c]['car_year'], 'license_plate' => $cars[$c]['license_plate'], 'fuel_type' => $cars[$c]['fuel_type'], 'power' => $cars[$c]['power'], 'model' => $cars[$c]['model'], 'colour' => $cars[$c]['colour'], 'brand' => $cars[$c]['brand']));
        //                     $not_available = false;
        //                     break;
        //                 } else if ($checkOutDate > strtotime($reservations[$r]['check_out_date']) && $checkInDate < strtotime($reservations[$r]['check_in_date'])) {
        //                     // condition kapag yung check in at check out ay nasa loob ng input na check in at check out. dapat not available din kapag ganon
        //                     array_push($ids, array('car_id' => $cars[$c]['id'], 'not_available' => true, 'car_year' => $cars[$c]['car_year'], 'license_plate' => $cars[$c]['license_plate'], 'fuel_type' => $cars[$c]['fuel_type'], 'power' => $cars[$c]['power'], 'model' => $cars[$c]['model'], 'colour' => $cars[$c]['colour'], 'brand' => $cars[$c]['brand']));
        //                     $not_available = false;
        //                     break;
        //                 }
        //             }
        //         } else continue;
        //     }
        //     if ($not_available) {
        //         array_push($ids, array('car_id' => $cars[$c]['id'], 'not_available' => false, 'car_year' => $cars[$c]['car_year'], 'license_plate' => $cars[$c]['license_plate'], 'fuel_type' => $cars[$c]['fuel_type'], 'power' => $cars[$c]['power'], 'model' => $cars[$c]['model'], 'colour' => $cars[$c]['colour'], 'brand' => $cars[$c]['brand']));
        //     }
        // }
        // return $ids;
        // $cars =  collect(DB::select("SELECT c.model, (SELECT r.car_id FROM reservations AS r WHERE r.car_id = c.id AND ((? BETWEEN r.check_in_date AND r.check_out_date OR ? BETWEEN r.check_in_date AND r.check_out_date) OR (r.check_in_date BETWEEN ? AND ? AND r.check_out_date BETWEEN ? AND ?))) AS not_available
        // FROM cars AS c where c.model like ?", [$checkInDate, $checkOutDate, $checkInDate, $checkOutDate, $checkInDate, $checkOutDate, $car]));
        // $perPage = 10;
        // $page = 1;

        // $cars = $cars->paginate($perPage, ['*'], 'page', $page);




        //     $cars = collect(DB::select("SELECT 
        //     c.model,
        //     (SELECT r.car_id FROM reservations AS r WHERE r.car_id = c.id AND ((? BETWEEN r.check_in_date AND r.check_out_date OR ? BETWEEN r.check_in_date AND r.check_out_date) OR (r.check_in_date BETWEEN ? AND ? AND r.check_out_date BETWEEN ? AND ?))) AS not_available,
        //     c.id,
        //     c.car_year,
        //     c.license_plate,
        //     c.fuel_type,
        //     c.power,
        //     c.model,
        //     c.colour,
        //     c.brand
        // FROM cars AS c where c.model like ?", [$checkInDate, $checkOutDate, $checkInDate, $checkOutDate, $checkInDate, $checkOutDate, $car]));



        // DB::enableQueryLog(); // Enable query log
        $cars = collect(DB::select("SELECT 
        c.model,
        (SELECT r.car_id FROM reservations AS r WHERE r.car_id = c.id AND ((? BETWEEN r.check_in_date AND r.check_out_date OR ? BETWEEN r.check_in_date AND r.check_out_date) OR (r.check_in_date BETWEEN ? AND ? AND r.check_out_date BETWEEN ? AND ?))) AS not_available,
        c.id,
        c.car_year,
        c.license_plate,
        c.fuel_type,
        c.power,
        c.model,
        c.colour,
        c.brand
    FROM cars AS c where c.model like ?", [$checkInDate, $checkOutDate, $checkInDate, $checkOutDate, $checkInDate, $checkOutDate, $car]));

return $cars;
        $perPage = 10; // Number of cars per page

        $carsPaginated = $cars->paginate($perPage);

        // Your Eloquent query executed by using get()

        // dd(DB::getQueryLog()); // Show results of log
        // $perPage = 2;
        // $page = 1;

        // $cars = new \Illuminate\Pagination\LengthAwarePaginator(
        //     $cars->forPage($page, $perPage),
        //     $cars->count(),
        //     $perPage,
        //     $page,
        //     [
        //         'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
        //         'pageName' => 'page',
        //     ]
        // );

        return $carsPaginated;
    }
}
