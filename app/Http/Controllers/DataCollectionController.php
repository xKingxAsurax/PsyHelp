<?php

namespace App\Http\Controllers;

use App\Services\DataCollectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataCollectionController extends Controller
{
    protected $dataCollectionService;

    public function __construct(DataCollectionService $dataCollectionService)
    {
        $this->dataCollectionService = $dataCollectionService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'events' => 'required|array',
            'events.*.type' => 'required|string',
            'events.*.data' => 'required|array'
        ]);

        foreach ($validated['events'] as $event) {
            $this->dataCollectionService->logUserAction(
                Auth::id(),
                $event['type'],
                json_encode($event['data']),
                $event['data']
            );
        }

        return response()->json(['message' => 'Datos registrados correctamente']);
    }

    public function summary()
    {
        // Obtener resumen de datos recopilados para el panel de administración
        $summary = [
            'total_interactions' => UserData::where('data_type', 'interaction')->count(),
            'total_page_views' => UserData::where('data_type', 'page_view')->count(),
            'total_errors' => UserData::where('data_type', 'error')->count(),
            'recent_activities' => UserData::with('user')
                                        ->orderBy('created_at', 'desc')
                                        ->limit(50)
                                        ->get()
        ];

        return response()->json($summary);
    }
} 