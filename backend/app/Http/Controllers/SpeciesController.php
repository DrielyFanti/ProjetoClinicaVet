<?php

namespace App\Http\Controllers;

use App\Models\Species;
use App\Http\Resources\SpeciesResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpeciesController extends Controller
{
    public function index()
    {
        try {
            $species = Species::orderBy('name')->get();
            return SpeciesResource::collection($species);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar espécies',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Species $species)
    {
        try {
            return new SpeciesResource($species);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar espécie',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:2|max:100|unique:species,name',
                'description' => 'nullable|string|max:1000',
                'is_active' => 'boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $species = Species::create($validator->validated());
            return new SpeciesResource($species);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar espécie',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Species $species)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|min:2|max:100|unique:species,name,' . $species->id,
                'description' => 'nullable|string|max:1000',
                'is_active' => 'sometimes|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $species->update($validator->validated());
            return new SpeciesResource($species);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar espécie',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Species $species)
    {
        try {
            // Verifica se a espécie tem animais cadastrados
            if ($species->animals()->exists()) {
                return response()->json([
                    'message' => 'Não é possível excluir uma espécie que possui animais cadastrados'
                ], 409);
            }

            $species->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir espécie',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
