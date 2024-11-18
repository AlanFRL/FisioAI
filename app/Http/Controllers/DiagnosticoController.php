<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiagnosticoController extends Controller
{
    public function index()
    {
        return view('pages.diagnostico.index');
    }

    public function predict(Request $request)
    {
        $zona = $request->input('zona_afectada');
        $dolor = $request->input('dolor_actual');
        $duracion = $request->input('duracion_dolor');

        // Aquí llamas a tu modelo (por ejemplo, vía Python o API)
        $resultado = $this->callPythonModel($zona, $dolor, $duracion);

        return view('pages.diagnostico.result', compact('resultado'));
    }

    private function callPythonModel($zona, $dolor, $duracion)
    {
        // Aquí puedes llamar al script de Python
        // Puedes usar `shell_exec` o una API si el modelo está en un servidor.
        $command = escapeshellcmd("python predict_model.py $zona $dolor $duracion");
        $output = shell_exec($command);

        return json_decode($output, true); // Suponiendo que el modelo retorna JSON
    }
}
