<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use App\Http\Resources\BreedResource;
use Illuminate\Http\Request;

class BreedController extends Controller
{
    public function index(Request $request)
    {
        $query = Breed::with('species');
        
        if ($request->has('species_id')) {
            $query->where('species_id', $request->species_id);
        }
        
        $breeds = $query->get();
        return BreedResource::collection($breeds);
    }

    public function show(Breed $breed)
    {
        return response()->json($breed);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'species_id' => 'required|exists:species,id',
        ]);

        $breed = Breed::create($request->all());
        return response()->json($breed, 201);
    }

    public function update(Request $request, Breed $breed)
    {
        $request->validate([
            'name' => 'string',
            'species_id' => 'exists:species,id',
        ]);

        $breed->update($request->all());
        return response()->json($breed);
    }

    public function destroy(Breed $breed)
    {
        $breed->delete();
        return response()->json(null, 204);
    }
}
