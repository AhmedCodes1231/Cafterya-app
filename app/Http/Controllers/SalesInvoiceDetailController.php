<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesInvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(\App\Models\SalesInvoiceDetail::all());
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
        $detail = \App\Models\SalesInvoiceDetail::create($request->all());
        return response()->json($detail, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $detail = \App\Models\SalesInvoiceDetail::findOrFail($id);
        return response()->json($detail);
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
        $detail = \App\Models\SalesInvoiceDetail::findOrFail($id);
        $detail->update($request->all());
        return response()->json($detail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $detail = \App\Models\SalesInvoiceDetail::findOrFail($id);
        $detail->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
