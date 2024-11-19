<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use App\Models\Tratamiento;

use Illuminate\Http\Request;

class EjerciciosController extends Controller
{
    public function muneca_()
    {

        return view('pages.ejercicios.muneca.index');
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
        return view("pages.ejercicios.{$nombre}.index", [
            'ejercicio' => $ejercicio,
            'tratamiento' => $tratamiento,
        ]);
    }
}
