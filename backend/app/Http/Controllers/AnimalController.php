<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Http\Resources\AnimalResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $animals = Animal::with(['species', 'tutor'])->orderBy('name')->get();
            return AnimalResource::collection($animals);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar animais',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:2|max:100',
                'species_id' => 'required|exists:species,id',
                'tutor_id' => 'required|exists:tutors,id',
                'birth_date' => 'nullable|date',
                'gender' => 'required|in:male,female',
                'weight' => 'nullable|numeric|min:0|max:1000',
                'color' => 'nullable|string|max:50',
                'notes' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $animal = Animal::create($validator->validated());
            return new AnimalResource($animal->load(['species', 'tutor']));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar animal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
        try {
            return new AnimalResource($animal->load(['species', 'tutor']));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar animal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Animal $animal)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|min:2|max:100',
                'species_id' => 'sometimes|required|exists:species,id',
                'tutor_id' => 'sometimes|required|exists:tutors,id',
                'birth_date' => 'nullable|date',
                'gender' => 'sometimes|required|in:male,female',
                'weight' => 'nullable|numeric|min:0|max:1000',
                'color' => 'nullable|string|max:50',
                'notes' => 'nullable|string|max:1000',
                'is_active' => 'sometimes|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $animal->update($validator->validated());
            return new AnimalResource($animal->load(['species', 'tutor']));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar animal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal)
    {
        try {
            $animal->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir animal',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
