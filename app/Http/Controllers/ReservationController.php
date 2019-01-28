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

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'workplace_id' => 'required|exists:workplaces,id',
            'occupation_time' => 'required|date_format:Y-m-d\TH:00|after:' .
                \Carbon\Carbon::now() . '|unique:reservations,occupation_time,NULL,id,deleted_at,NULL,workplace_id,' .
            $request->get('workplace_id')
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
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json(['error' => 'No reservation for provided id.'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'workplace_id' => 'required|exists:workplaces,id',
            'occupation_time' => 'required|date_format:Y-m-d\TH:00|after:' .
                \Carbon\Carbon::now() . '|unique:reservations,occupation_time,'. $reservation->id . ',id,deleted_at,NULL,workplace_id,' .
                $request->get('workplace_id')
        ]);

        $reservation->fill($request->all());
        $reservation->save();

        return response()->json($reservation, Response::HTTP_OK);
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
