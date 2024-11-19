<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use App\Models\Tratamiento;
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

        // Crear un nuevo diagnóstico y asignar cada campo
        $diagnostico = new Diagnostico();
        $diagnostico->user_id = auth()->id(); // Asigna el ID del usuario autenticado
        $diagnostico->peso = $request->input('peso');
        $diagnostico->altura = $request->input('altura');
        $diagnostico->zona_afectada = $request->input('zona_afectada');
        $diagnostico->nivel_dolor = $request->input('nivel_dolor');
        $diagnostico->lesion_dias = $request->input('lesion_dias');
        $diagnostico->lesion_previa = $request->input('lesion_previa');
        $diagnostico->diagnostico = $request->input('diagnostico');
        $diagnostico->save(); // Guarda el registro en la base de datos

        return redirect()->route('diagnosticos.index')->with('success', 'Diagnóstico creado exitosamente.');
    }

    public function show(Diagnostico $diagnostico)
    {
        return view('pages.planes.show', compact('diagnostico'));
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
