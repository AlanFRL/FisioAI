<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use App\Models\User;
use App\Models\Tratamiento;
use App\Models\Set;
use App\Models\ResultadoEjercicio;
use Illuminate\Http\Request;

class SeguimientoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Último diagnóstico
        $ultimoDiagnostico = Diagnostico::where('user_id', $user->id)->latest()->first();

        // Historial de diagnósticos
        $diagnosticos = Diagnostico::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        // Plan actual (tratamiento activo)
        $planActual = $ultimoDiagnostico 
            ? Tratamiento::where('diagnostico_id', $ultimoDiagnostico->id)->first()
            : null;

        $resultados = collect();
        $totalEjerciciosEsperados = 0;
        $totalEjerciciosRealizados = 0;

        if ($planActual) {
            // Fechas y set
            $diasPlan = $planActual->fecha_inicio->diffInDays($planActual->fecha_final) + 1; // Incluye el último día
            $set = $planActual->set;
            $ejerciciosSet = $set ? $set->ejercicios : collect();

            // Total ejercicios esperados
            $totalEjerciciosEsperados = $diasPlan * $ejerciciosSet->count();

            // Resultados
            $resultados = ResultadoEjercicio::where('tratamiento_id', $planActual->id)
                ->with('ejercicio')
                ->get();

            $totalEjerciciosRealizados = $resultados->count();
        }

        // KPIs
        $porcentajeProgreso = $totalEjerciciosEsperados > 0
            ? ($totalEjerciciosRealizados / $totalEjerciciosEsperados) * 100
            : 0;

        $resultadosAltos = $resultados->where('porcentaje_precision', '>=', 80)->count();
        $resultadosBajos = $resultados->where('porcentaje_precision', '<', 50)->count();

        return view('pages.seguimiento.index', compact(
            'user',
            'ultimoDiagnostico',
            'diagnosticos',
            'planActual',
            'resultados',
            'totalEjerciciosEsperados',
            'totalEjerciciosRealizados',
            'porcentajeProgreso',
            'resultadosAltos',
            'resultadosBajos'
        ));
    }
}
