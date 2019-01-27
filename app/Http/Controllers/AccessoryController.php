<?php

namespace App\Http\Controllers;

use App\Accessory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accessories = Accessory::all();

        return response()->json($accessories, Response::HTTP_OK);
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
            'model' => 'required',
            'type_id' => 'exists:types,id',
            'mark' => 'required|max:100|unique:accessories',
            'purchase_year' => 'required|digits:4|integer|min:1900|max:'.\Carbon\Carbon::tomorrow()->year,
            'value' => "required|regex:/^\d*(\.\d{1,2})?$/",
            'description' => 'required|min:5'
        ]);

        $accessory = Accessory::create($request->all());


        return response()->json($accessory, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$accessory = Accessory::with(['type', 'workplace'])->find($id)) {
            return response()->json(['error' => 'No accessory for provided id.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($accessory, Response::HTTP_OK);
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
        $accessory = Accessory::find($id);

        if (!$accessory) {
            return response()->json(['error' => 'No accessory for provided id.'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'model' => 'required',
            'type_id' => 'required|exists:types,id',
            'mark' => 'required|max:100|unique:accessories,mark,' . $accessory->id . ',id',
            'purchase_year' => 'required|digits:4|integer|min:1900|max:'.\Carbon\Carbon::tomorrow()->year,
            'value' => "required|regex:/^\d*(\.\d{1,2})?$/",
            'description' => 'required|min:5'
        ]);

        $accessory->fill($request->all());
        $accessory->save();

        return response()->json($accessory, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accessory $accessory)
    {
        $accessory->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
