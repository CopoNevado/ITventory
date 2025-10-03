<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function index()
    {
        return Location::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:locations',
            'description' => 'nullable|string',
        ]);

        $location = Location::create($request->all());
        return response()->json($location, 201);
    }

    public function show(Location $location)
    {
        return $location;
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'sometimes|string|unique:locations,name,' . $location->id,
            'description' => 'nullable|string',
        ]);

        $location->update($request->all());
        return response()->json($location, 200);
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return response()->json(null, 204);
    }
}
