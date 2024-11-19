<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use App\Models\Tratamiento;
use App\Models\Set;
use App\Models\ResultadoEjercicio;
use Illuminate\Http\Request;

class DiagnosticoController extends Controller
{
    public function index()
    {
        // Obtén los diagnósticos del usuario autenticado
        $diagnosticos = Diagnostico::where('user_id', auth()->id())->get();
        //$diagnosticos = Diagnostico::all();
        return view('pages.planes.index', compact('diagnosticos'));
    }

    public function create()
    {
        return view('pages.planes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'peso' => 'required|numeric|min:1|max:300',
            'altura' => 'required|integer|min:50|max:250',
            'zona_afectada' => 'required|string|max:255',
            'nivel_dolor' => 'required|integer|min:1|max:10',
            'lesion_dias' => 'required|integer|min:0',
            'lesion_previa' => 'required|boolean',
            'diagnostico' => 'required|string|max:255',
        ]);

        // Crear diagnóstico
        $diagnostico = Diagnostico::create([
            'user_id' => auth()->id(),
            'peso' => $request->peso,
            'altura' => $request->altura,
            'zona_afectada' => $request->zona_afectada,
            'nivel_dolor' => $request->nivel_dolor,
            'lesion_dias' => $request->lesion_dias,
            'lesion_previa' => $request->lesion_previa,
            'diagnostico' => $request->diagnostico,
        ]);

        // Buscar el set de ejercicios correspondiente al diagnóstico
        $set = Set::where('diagnostico', $request->diagnostico)->first();

        // Crear tratamiento relacionado con el diagnóstico
        Tratamiento::create([
            'diagnostico_id' => $diagnostico->id,
            'set_id' => $set ? $set->id : null,
            'fecha_inicio' => now(),
            'fecha_final' => now()->addDays(10),
        ]);

        return redirect()->route('diagnosticos.index')->with('success', 'Plan creado exitosamente.');
    }

    public function show(Diagnostico $diagnostico)
    {
        // Obtener el tratamiento asociado al diagnóstico
        $tratamiento = $diagnostico->tratamiento;

        // Si no hay tratamiento, redirigir con un mensaje
        if (!$tratamiento) {
            return redirect()->route('diagnosticos.index')->with('error', 'Este diagnóstico no tiene un tratamiento asociado.');
        }

        // Obtener el set de ejercicios asociado al tratamiento
        $set = $tratamiento->set;

        // Obtener los ejercicios del set
        $ejercicios = $set ? $set->ejercicios : [];

        // Comprobar cuáles ejercicios ya tienen resultados registrados para hoy
        $hoy = now()->toDateString();
        $ejerciciosEstado = $ejercicios->map(function ($ejercicio) use ($tratamiento, $hoy) {
            $resultado = ResultadoEjercicio::where('tratamiento_id', $tratamiento->id)
                ->where('ejercicio_id', $ejercicio->id)
                ->whereDate('fecha', $hoy)
                ->first();

            return [
                'ejercicio' => $ejercicio,
                'completado' => $resultado ? true : false,
            ];
        });
        
        return view('pages.planes.show', compact('diagnostico', 'tratamiento', 'set', 'ejerciciosEstado'));
    }

    public function edit(Diagnostico $diagnostico)
    {
        return view('pages.planes.edit', compact('diagnostico'));
    }

    public function update(Request $request, Diagnostico $diagnostico)
    {
        $request->validate([
            'zona_afectada' => 'required|string|max:255',
            'nivel_dolor' => 'required|integer|min:1|max:10',
            'lesion_dias' => 'required|integer|min:0',
            'lesion_previa' => 'required|boolean',
            'diagnostico' => 'required|string|max:255',
        ]);

        $diagnostico->update($request->all());

        return redirect()->route('diagnosticos.index')->with('success', 'Diagnóstico actualizado exitosamente.');
    }

    public function destroy(Diagnostico $diagnostico)
    {
        $diagnostico->delete();

        return redirect()->route('diagnosticos.index')->with('success', 'Diagnóstico eliminado exitosamente.');
    }
}
