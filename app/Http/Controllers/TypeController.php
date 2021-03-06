<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::with('accessories')->get();

        return response()->json($types, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
            'name' => 'required|max:50|unique:types'
        ]);

        $type = new Type();
        $type->name = $request->input('name');
        $type->save();

        return response()->json($type, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$type = Type::with('accessories')->find($id)) {
            return response()->json(['error' => 'No type for provided id.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($type, Response::HTTP_OK);
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
        $type = Type::find($id);

        if (!$type) {
            return response()->json(['error' => 'No type for provided id.'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'name' => 'required|max:50|unique:types,name,' . $type->id . ',id'
        ]);

        $type->fill($request->all());
        $type->save();

        return response()->json($type, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
