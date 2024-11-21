<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Detalles del Plan</h1>

        <!-- Datos del Diagnóstico -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">Diagnóstico</h2>
            <p class="mb-2"><strong class="text-gray-600">Zona Afectada:</strong> {{ $diagnostico->zona_afectada }}</p>
            <p class="mb-2"><strong class="text-gray-600">Nivel de Dolor:</strong> {{ $diagnostico->nivel_dolor }}</p>
            <p><strong class="text-gray-600">Diagnóstico:</strong> {{ $diagnostico->diagnostico }}</p>
        </div>

        <!-- Datos del Tratamiento -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">Tratamiento</h2>
            <p class="mb-2"><strong class="text-gray-600">Fecha de Inicio:</strong> {{ $tratamiento->fecha_inicio }}</p>
            <p><strong class="text-gray-600">Fecha Final:</strong> {{ $tratamiento->fecha_final }}</p>
        </div>

        <!-- Ejercicios del Set -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Ejercicios</h2>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-gray-200 shadow-lg rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">ID</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">Ejercicio</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">Descripción</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">Duración</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">Repeticiones</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">Precauciones</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">Estado</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ejerciciosEstado as $estado)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-6 py-4">{{ $estado['ejercicio']->id }}</td>
                                <td class="border px-6 py-4">{{ $estado['ejercicio']->nombre }}</td>
                                <td class="border px-6 py-4">{{ $estado['ejercicio']->descripcion }}</td>
                                <td class="border px-6 py-4">{{ $estado['ejercicio']->duracion }} series</td>
                                <td class="border px-6 py-4">{{ $estado['ejercicio']->repeticiones }}</td>
                                <td class="border px-6 py-4">{{ $estado['ejercicio']->precauciones }}</td>
                                <td class="border px-6 py-4">
                                    @if ($estado['completado'])
                                        <span class="text-green-500">Completado</span>
                                    @else
                                        <span class="text-red-500">Pendiente</span>
                                    @endif
                                </td>
                                <td class="border px-6 py-4">
                                    @if (!$estado['completado'])
                                        <a href="{{ route('ejercicios.dinamico', ['nombre' => strtolower($diagnostico->zona_afectada) . '_e' . $estado['ejercicio']->id, 'ejercicioId' => $estado['ejercicio']->id, 'tratamientoId' => $tratamiento->id]) }}" 
                                            class="inline-block bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600">
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
    </div>
</x-app-layout>
