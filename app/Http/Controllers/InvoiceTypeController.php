<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(\App\Models\InvoiceType::all());
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
        $type = \App\Models\InvoiceType::create($request->all());
        return response()->json($type, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $type = \App\Models\InvoiceType::findOrFail($id);
        return response()->json($type);
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
        $type = \App\Models\InvoiceType::findOrFail($id);
        $type->update($request->all());
        return response()->json($type);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $type = \App\Models\InvoiceType::findOrFail($id);
        $type->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
