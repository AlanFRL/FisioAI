<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use App\Models\User;
use App\Models\Tratamiento;
use App\Models\Set;
use App\Models\ResultadoEjercicio;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SeguimientoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Historial de diagnósticos
        $diagnosticos = Diagnostico::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        // Colecciones para acumular estadísticas
        $planes = collect();
        $totalEjerciciosEsperadosGlobal = 0;
        $totalEjerciciosRealizadosGlobal = 0;
        $resultadosGlobales = collect();

        foreach ($diagnosticos as $diagnostico) {
            $tratamiento = $diagnostico->tratamiento;
            if (!$tratamiento) {
                continue; // Saltar diagnósticos sin tratamiento
            }

            // Fechas y set
            $diasPlan = $tratamiento->fecha_inicio->diffInDays($tratamiento->fecha_final);
            $set = $tratamiento->set;
            $ejerciciosSet = $set ? $set->ejercicios : collect();

            // Total de ejercicios esperados
            $totalEjerciciosEsperados = ($diasPlan + 1) * $ejerciciosSet->count();
            $resultados = ResultadoEjercicio::where('tratamiento_id', $tratamiento->id)->with('ejercicio')->get();
            $totalEjerciciosRealizados = $resultados->count();

            // Calcular progreso
            $porcentajeProgreso = $totalEjerciciosEsperados > 0
                ? ($totalEjerciciosRealizados / $totalEjerciciosEsperados) * 100
                : 0;

            // KPIs por plan
            $resultadosAltos = $resultados->where('porcentaje_precision', '>=', 80)->count();
            $resultadosBajos = $resultados->where('porcentaje_precision', '<', 50)->count();

            $planes->push([
                'id' => $tratamiento->id,
                'tratamiento' => $tratamiento,
                'totalEjerciciosEsperados' => $totalEjerciciosEsperados,
                'totalEjerciciosRealizados' => $totalEjerciciosRealizados,
                'porcentajeProgreso' => $porcentajeProgreso,
                'resultadosAltos' => $resultadosAltos,
                'resultadosBajos' => $resultadosBajos,
                'resultados' => $resultados,
            ]);

            // Acumular estadísticas globales
            $totalEjerciciosEsperadosGlobal += $totalEjerciciosEsperados;
            $totalEjerciciosRealizadosGlobal += $totalEjerciciosRealizados;
            $resultadosGlobales = $resultadosGlobales->merge($resultados);
        }

        // KPIs globales
        $resultadosAltosGlobal = $resultadosGlobales->where('porcentaje_precision', '>=', 80)->count();
        $resultadosBajosGlobal = $resultadosGlobales->where('porcentaje_precision', '<', 50)->count();
        $porcentajeProgresoGlobal = $totalEjerciciosEsperadosGlobal > 0
            ? ($totalEjerciciosRealizadosGlobal / $totalEjerciciosEsperadosGlobal) * 100
            : 0;

        return view('pages.seguimiento.index', compact(
            'user',
            'planes',
            'diagnosticos',
            'totalEjerciciosEsperadosGlobal',
            'totalEjerciciosRealizadosGlobal',
            'porcentajeProgresoGlobal',
            'resultadosAltosGlobal',
            'resultadosBajosGlobal'
        ));
    }

    public function generarReporteProgreso()
    {
        $user = auth()->user();
        $planes = Diagnostico::where('user_id', $user->id)->with('tratamiento.set')->get();

        // Datos para el reporte
        $totalEjerciciosRealizados = ResultadoEjercicio::whereHas('tratamiento', function ($query) use ($user) {
            $query->whereHas('diagnostico', fn($q) => $q->where('user_id', $user->id));
        })->count();

        $totalEjerciciosEsperados = Tratamiento::whereHas('diagnostico', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('set.ejercicios')->get()->sum(function ($tratamiento) {
            $diasPlan = $tratamiento->fecha_inicio->diffInDays($tratamiento->fecha_final) + 1;
            return $diasPlan * $tratamiento->set->ejercicios->count();
        });

        $progresoGlobal = $totalEjerciciosEsperados > 0
            ? ($totalEjerciciosRealizados / $totalEjerciciosEsperados) * 100
            : 0;

        $data = [
            'user' => $user,
            'planes' => $planes,
            'totalEjerciciosRealizados' => $totalEjerciciosRealizados,
            'totalEjerciciosEsperados' => $totalEjerciciosEsperados,
            'progresoGlobal' => number_format($progresoGlobal, 2),
            'fechaGeneracion' => now()->format('d/m/Y'),
            'edad' => now()->year - $user->fecha_nacimiento->year,
        ];

        $pdf = Pdf::loadView('pages.reportes.progresogeneral', $data);

        return $pdf->download('reporte_progreso_general.pdf');
    }

    public function generarReporteAdherencia()
    {
        $user = auth()->user();
        $tratamientos = Tratamiento::whereHas('diagnostico', fn($q) => $q->where('user_id', $user->id))->with('set.ejercicios')->get();

        $data = $tratamientos->map(function ($tratamiento) {
            $diasPlan = $tratamiento->fecha_inicio->diffInDays($tratamiento->fecha_final);
            $ejerciciosEsperados = ($diasPlan + 1) * $tratamiento->set->ejercicios->count();

            $ejerciciosRealizados = ResultadoEjercicio::where('tratamiento_id', $tratamiento->id)->count();
            $adherencia = $ejerciciosEsperados > 0 ? ($ejerciciosRealizados / $ejerciciosEsperados) * 100 : 0;

            // Obtener ejercicios por día
            $ejerciciosPorDia = collect();
            for ($i = 0; $i <= $diasPlan; $i++) {
                $fecha = $tratamiento->fecha_inicio->copy()->addDays($i);
                $ejerciciosRealizadosDia = ResultadoEjercicio::where('tratamiento_id', $tratamiento->id)
                    ->whereDate('fecha', $fecha)
                    ->get();
                $ejerciciosPorDia->push([
                    'fecha' => $fecha->format('d/m/Y'),
                    'ejercicios' => $ejerciciosRealizadosDia,
                    'totalRealizados' => $ejerciciosRealizadosDia->count(),
                    'pendientes' => $tratamiento->set->ejercicios->count() - $ejerciciosRealizadosDia->count(),
                ]);
            }

            return [
                'tratamiento' => $tratamiento,
                'diasPlan' => $diasPlan,
                'ejerciciosEsperados' => $ejerciciosEsperados,
                'ejerciciosRealizados' => $ejerciciosRealizados,
                'adherencia' => number_format($adherencia, 2),
                'ejerciciosPorDia' => $ejerciciosPorDia,
            ];
        });

        $pdf = Pdf::loadView('pages.reportes.adherencia', [
            'user' => $user,
            'data' => $data,
            'fechaGeneracion' => now()->format('d/m/Y'),
            'edad' => now()->year - $user->fecha_nacimiento->year,
        ]);

        return $pdf->download('reporte_adherencia.pdf');
    }
}
