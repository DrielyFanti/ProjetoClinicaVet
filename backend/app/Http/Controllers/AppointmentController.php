<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Resources\AppointmentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['animal', 'tutor'])->orderBy('date', 'desc')->get();
        return AppointmentResource::collection($appointments);
    }

    public function show(Appointment $appointment)
    {
        return new AppointmentResource($appointment->load(['animal', 'tutor']));
    }

    public function store(Request $request)
    {
        \Log::info('Dados recebidos na criação de consulta:', $request->all());

        $validator = Validator::make($request->all(), [
            'animal_id' => 'required|exists:animals,id',
            'tutor_id' => 'required|exists:tutors,id',
            'service' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:agendada,realizada,cancelada',
        ]);

        if ($validator->fails()) {
            \Log::error('Erros de validação:', $validator->errors()->toArray());
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $appointment = Appointment::create($validator->validated());
            \Log::info('Consulta criada com sucesso:', $appointment->toArray());
            return new AppointmentResource($appointment->load(['animal', 'tutor']));
        } catch (\Exception $e) {
            \Log::error('Erro ao criar consulta:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Erro ao criar consulta',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validator = Validator::make($request->all(), [
            'animal_id' => 'sometimes|required|exists:animals,id',
            'tutor_id' => 'sometimes|required|exists:tutors,id',
            'service' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'notes' => 'nullable|string',
            'status' => 'sometimes|required|in:agendada,realizada,cancelada',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $appointment->update($validator->validated());
        return new AppointmentResource($appointment->load(['animal', 'tutor']));
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json(null, 204);
    }
} 