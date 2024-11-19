<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Detalles del Plan</h1>

        <!-- Datos del Diagnóstico -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold">Diagnóstico</h2>
            <p><strong>Zona Afectada:</strong> {{ $diagnostico->zona_afectada }}</p>
            <p><strong>Nivel de Dolor:</strong> {{ $diagnostico->nivel_dolor }}</p>
            <p><strong>Diagnóstico:</strong> {{ $diagnostico->diagnostico }}</p>
        </div>

        <!-- Datos del Tratamiento -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold">Tratamiento</h2>
            <p><strong>Fecha de Inicio:</strong> {{ $tratamiento->fecha_inicio }}</p>
            <p><strong>Fecha Final:</strong> {{ $tratamiento->fecha_final }}</p>
        </div>

        <!-- Ejercicios del Set -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold">Ejercicios</h2>
            <table class="table-auto w-full border-collapse border border-gray-400">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Ejercicio</th>
                        <th class="border px-4 py-2">Descripción</th>
                        <th class="border px-4 py-2">Duración</th>
                        <th class="border px-4 py-2">Repeticiones</th>
                        <th class="border px-4 py-2">Precauciones</th>
                        <th class="border px-4 py-2">Estado</th>
                        <th class="border px-4 py-2">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ejerciciosEstado as $estado)
                        <tr>
                            <td class="border px-4 py-2">{{ $estado['ejercicio']->id }}</td>
                            <td class="border px-4 py-2">{{ $estado['ejercicio']->nombre }}</td>
                            <td class="border px-4 py-2">{{ $estado['ejercicio']->descripcion }}</td>
                            <td class="border px-4 py-2">{{ $estado['ejercicio']->duracion }} series</td>
                            <td class="border px-4 py-2">{{ $estado['ejercicio']->repeticiones }}</td>
                            <td class="border px-4 py-2">{{ $estado['ejercicio']->precauciones }}</td>
                            <td class="border px-4 py-2">
                                @if ($estado['completado'])
                                    <span class="text-green-500">Completado</span>
                                @else
                                    <span class="text-red-500">Pendiente</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">
                                @if (!$estado['completado'])
                                <a href="{{ route('ejercicios.dinamico', ['nombre' => strtolower($diagnostico->zona_afectada) . '_e' . $estado['ejercicio']->id, 'ejercicioId' => $estado['ejercicio']->id, 'tratamientoId' => $tratamiento->id]) }}" 
                                    class="btn bg-indigo-500 text-white px-2 py-1">
                                    Comenzar Ejercicio
                                 </a>
                                @else
                                    <span class="text-gray-500">Hecho</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
