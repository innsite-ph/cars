<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = DB::table('reservations')->join('users', 'users.id', '=', 'reservations.user_id')->join('cars', 'cars.id', '=', 'reservations.car_id')->get();
        return $reservations;
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
    public function store(ReservationRequest $request)
    {
        $notAvailable= DB::table('reservations')->where('car_id', '=', $request->car_id)->where(function ($query) use ($request) {
            $query->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date]);
        })->get();
        if (strtotime($request->check_in_date) < strtotime($request->check_out_date)) {
            if (count($notAvailable) == 0) {
                Reservation::create($request->validated());
                return '1';
            } else
                return '0';
        } else return "check in date must be earlier than check out date!";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(ReservationRequest $request, string $id)
    {
        if (strtotime($request->check_in_date) < strtotime($request->check_out_date)) {
            $reservations = Reservation::find($id);
            $reservations->car_id = $request->car_id;
            $reservations->user_id = $request->user_id;
            $reservations->check_in_date = $request->check_in_date;
            $reservations->check_out_date = $request->check_out_date;
            $reservations->save();
            return true;
        } else return "check in date must be earlier than check out date!";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        Reservation::destroy($id);
        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}
