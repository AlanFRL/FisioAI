<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Listado de Diagnósticos</h1>
        <a href="{{ route('diagnosticos.create') }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white mb-4">
            Crear Nuevo Diagnóstico
        </a>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Zona Afectada</th>
                    <th class="px-4 py-2">Nivel de Dolor</th>
                    <th class="px-4 py-2">Diagnóstico</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($diagnosticos as $diagnostico)
                    <tr>
                        <td class="border px-4 py-2">{{ $diagnostico->id }}</td>
                        <td class="border px-4 py-2">{{ $diagnostico->zona_afectada }}</td>
                        <td class="border px-4 py-2">{{ $diagnostico->nivel_dolor }}</td>
                        <td class="border px-4 py-2">{{ $diagnostico->diagnostico }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('diagnosticos.show', $diagnostico) }}" class="text-blue-500">Detalles</a>
                            <a href="{{ route('diagnosticos.edit', $diagnostico) }}" class="text-yellow-500 ml-2">Editar</a>
                            <form action="{{ route('diagnosticos.destroy', $diagnostico) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500" onclick="return confirm('¿Estás seguro de eliminar este diagnóstico?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
