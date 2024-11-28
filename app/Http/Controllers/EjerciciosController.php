<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use App\Models\Tratamiento;
use App\Models\ResultadoEjercicio;

use Illuminate\Http\Request;

class EjerciciosController extends Controller
{
    public function muneca_()
    {

        return view('pages.ejercicios.muneca.index');
    }
    public function hombro()
    {

        return view('pages.ejercicios.hombro.index');
    }

    public function ejercicio($nombre, $ejercicioId, $tratamientoId)
    {
        // Buscar el ejercicio
        $ejercicio = Ejercicio::find($ejercicioId);

        // Buscar el tratamiento
        $tratamiento = Tratamiento::find($tratamientoId);

        // Validar que existan
        if (!$ejercicio || !$tratamiento) {
            return redirect()->back()->with('error', 'El ejercicio o tratamiento no existe.');
        }

        // Pasar datos a la vista
        return view("pages.ejercicios.{$nombre}.index", compact('ejercicioId', 'tratamientoId', 'ejercicio'));
    }

    // GUARDAR EL RESULTADO DEL EJERCICIO
    public function guardarResultado(Request $request)
    {
        // Validar datos requeridos
        $request->validate([
            'tratamiento_id' => 'required|exists:tratamiento,id',
            'ejercicio_id' => 'required|exists:ejercicio,id',
            'porcentaje_precision' => 'required|numeric|min:0|max:100',
        ]);

        // Obtener los datos del request
        $tratamientoId = $request->input('tratamiento_id');
        $ejercicioId = $request->input('ejercicio_id');
        $porcentajePrecision = $request->input('porcentaje_precision');

        // Generar descripción genérica para observaciones
        $observaciones = $this->generarObservacion($porcentajePrecision);

        // Crear el registro en la base de datos
        $resultado = ResultadoEjercicio::create([
            'tratamiento_id' => $tratamientoId,
            'ejercicio_id' => $ejercicioId,
            'porcentaje_precision' => $porcentajePrecision,
            'observaciones' => $observaciones,
            'fecha' => now()->toDateString(),
        ]);

        // Obtener el diagnóstico asociado al tratamiento
        $tratamiento = Tratamiento::find($tratamientoId);
        $diagnostico = $tratamiento->diagnostico; // Asegúrate de que esta relación existe en tu modelo Tratamiento

        // Redirigir a la vista "show" del diagnóstico
        return redirect()->route('diagnosticos.show', ['diagnostico' => $diagnostico->id])
            ->with('success', 'Resultado guardado exitosamente.');
    }

    /**
     * Generar una observación genérica basada en el porcentaje de precisión.
     */
    private function generarObservacion($porcentajePrecision)
    {
        if ($porcentajePrecision < 50) {
            return 'El ejercicio no se completó adecuadamente. Se recomienda repetirlo con mayor atención a la técnica.';
        } elseif ($porcentajePrecision >= 50 && $porcentajePrecision < 80) {
            return 'El ejercicio se realizó de manera aceptable, pero hay margen de mejora.';
        } else {
            return 'El ejercicio se realizó correctamente con una alta precisión.';
        }
    }


}
