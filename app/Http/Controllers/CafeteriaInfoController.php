<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CafeteriaInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(\App\Models\CafeteriaInfo::all());
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
        $info = \App\Models\CafeteriaInfo::create($request->all());
        return response()->json($info, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $info = \App\Models\CafeteriaInfo::findOrFail($id);
        return response()->json($info);
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
    public function update(Request $request, $id)
    {
        $info = \App\Models\CafeteriaInfo::findOrFail($id);
        $info->update($request->all());
        return response()->json($info);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $info = \App\Models\CafeteriaInfo::findOrFail($id);
        $info->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
