<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Listado de Diagnósticos</h1>
        <a href="{{ route('diagnosticos.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-500 text-white rounded-lg shadow hover:bg-indigo-600">
            Crear Nuevo Diagnóstico
        </a>
        <div class="overflow-x-auto">
            <table class="table-auto w-full border border-gray-200 shadow-lg rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-600 font-semibold">ID</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-semibold">Zona Afectada</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-semibold">Nivel de Dolor</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-semibold">Diagnóstico</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($diagnosticos as $diagnostico)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-6 py-4">{{ $diagnostico->id }}</td>
                            <td class="border px-6 py-4">{{ $diagnostico->zona_afectada }}</td>
                            <td class="border px-6 py-4">{{ $diagnostico->nivel_dolor }}</td>
                            <td class="border px-6 py-4">{{ $diagnostico->diagnostico }}</td>
                            <td class="border px-6 py-4 flex items-center space-x-4">
                                <a href="{{ route('diagnosticos.show', $diagnostico) }}" class="text-blue-500 hover:text-blue-700">
                                    Detalles
                                </a>
                                <a href="{{ route('diagnosticos.edit', $diagnostico) }}" class="text-yellow-500 hover:text-yellow-700">
                                    Editar
                                </a>
                                <form action="{{ route('diagnosticos.destroy', $diagnostico) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('¿Estás seguro de eliminar este diagnóstico?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
