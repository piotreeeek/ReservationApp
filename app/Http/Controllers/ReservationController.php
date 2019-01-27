<?php

namespace App\Http\Controllers;

use App\Reservation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::with(['user', 'workplace'])->get();

        return response()->json($reservations, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lastSameWorkplaceReservation = Reservation::where('workplace_id', $request->get('workplace_id'))
                                                    ->orderBy('end_time', 'desc')
                                                    ->first();

        $request->validate([
            'user_id' => 'required',
            'workplace_id' => 'required',
            'start_time' => 'required|date_format:Y-m-d H:i:s|after:' . $lastSameWorkplaceReservation->end_time,
            'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_date',
        ]);

        $reservation = Reservation::create($request->all());

        return response()->json($reservation, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$reservation = Reservation::with(['user', 'workplace'])->find($id)) {
            return response()->json(['error' => 'No reservation for provided id.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($reservation, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
