<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function index()
    {
        try {
            $serviceTypes = ServiceType::all();
            return response()->json($serviceTypes);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar tipos de serviço: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0'
            ]);

            $serviceType = ServiceType::create($validated);
            return response()->json($serviceType, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar tipo de serviço: ' . $e->getMessage()], 500);
        }
    }

    public function show(ServiceType $serviceType)
    {
        try {
            return response()->json($serviceType);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar tipo de serviço: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, ServiceType $serviceType)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'price' => 'sometimes|numeric|min:0'
            ]);

            $serviceType->update($validated);
            return response()->json($serviceType);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar tipo de serviço: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(ServiceType $serviceType)
    {
        try {
            $serviceType->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar tipo de serviço: ' . $e->getMessage()], 500);
        }
    }
} 