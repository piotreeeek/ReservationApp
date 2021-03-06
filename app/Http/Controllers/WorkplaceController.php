<?php

namespace App\Http\Controllers;

use App\Workplace;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkplaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workplaces = Workplace::with('accessories')->get();

        return response()->json($workplaces, Response::HTTP_OK);
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
            'mark' => 'required|max:100|unique:workplaces',
            'description' => 'required|min:5'

        ]);

        $workplace = Workplace::create($request->all());


        return response()->json($workplace, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!$workplace = Workplace::with('accessories')->find($id)){
           return response()->json(['error' => 'No workplace for provided id.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($workplace, Response::HTTP_OK);
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
        $workplace = Workplace::find($id);

        if (!$workplace) {
            return response()->json(['error' => 'No workplace for provided id.'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'mark' => 'required|max:100|unique:workplaces,mark,' . $workplace->id . ',id',
            'description' => 'required|min:5'
        ]);

        $workplace->fill($request->all());
        $workplace->save();

        return response()->json($workplace, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Workplace $workplace)
    {
        $workplace->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }
}
