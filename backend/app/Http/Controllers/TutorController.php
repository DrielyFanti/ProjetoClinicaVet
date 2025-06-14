<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use App\Http\Resources\TutorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TutorController extends Controller
{
    public function index()
    {
        try {
            $tutors = Tutor::orderBy('name')->get();
            return TutorResource::collection($tutors);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar tutores',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Tutor $tutor)
    {
        try {
            return new TutorResource($tutor->load('animals'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar tutor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:2|max:100',
                'cpf' => 'required|string|size:14|unique:tutors,cpf',
                'email' => 'required|email|unique:tutors,email',
                'phone' => 'required|string|max:20',
                'whatsapp' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'state' => 'nullable|string|size:2',
                'zip_code' => 'nullable|string|max:10',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $tutor = Tutor::create($validator->validated());
            return new TutorResource($tutor);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar tutor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Tutor $tutor)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|min:2|max:100',
                'cpf' => 'sometimes|required|string|size:14|unique:tutors,cpf,' . $tutor->id,
                'email' => 'sometimes|required|email|unique:tutors,email,' . $tutor->id,
                'phone' => 'sometimes|required|string|max:20',
                'whatsapp' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'state' => 'nullable|string|size:2',
                'zip_code' => 'nullable|string|max:10',
                'is_active' => 'sometimes|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $tutor->update($validator->validated());
            return new TutorResource($tutor->load('animals'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar tutor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function destroy(Tutor $tutor)
    {
        try {
            // Verifica se o tutor tem animais cadastrados
            if ($tutor->animals()->exists()) {
                return response()->json([
                    'message' => 'Não é possível excluir um tutor que possui animais cadastrados'
                ], 409);
            }

            $tutor->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir tutor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}