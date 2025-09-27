<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(\App\Models\UserRole::all());
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
        $userRole = \App\Models\UserRole::create($request->all());
        return response()->json($userRole, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $userRole = \App\Models\UserRole::findOrFail($id);
        return response()->json($userRole);
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
        $userRole = \App\Models\UserRole::findOrFail($id);
        $userRole->update($request->all());
        return response()->json($userRole);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userRole = \App\Models\UserRole::findOrFail($id);
        $userRole->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
