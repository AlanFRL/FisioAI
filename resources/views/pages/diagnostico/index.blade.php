<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Diagnóstico</h1>

        <form method="POST" action="{{ route('diagnostico.predict') }}">
            @csrf
            <div class="mb-4">
                <label for="zona_afectada" class="block text-sm font-medium text-slate-200">Zona Afectada</label>
                <select id="zona_afectada" name="zona_afectada" class="form-select mt-1 block w-full">
                    <option value="0">Rodilla</option>
                    <option value="1">Tobillo</option>
                    <!-- Añade más zonas aquí -->
                </select>
            </div>

            <div class="mb-4">
                <label for="dolor_actual" class="block text-sm font-medium text-slate-200">Dolor Actual</label>
                <input type="number" id="dolor_actual" name="dolor_actual" min="1" max="10" class="form-input mt-1 block w-full" />
            </div>

            <div class="mb-4">
                <label for="duracion_dolor" class="block text-sm font-medium text-slate-200">Duración del Dolor (en días)</label>
                <input type="number" id="duracion_dolor" name="duracion_dolor" min="1" class="form-input mt-1 block w-full" />
            </div>

            <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">Diagnosticar</button>
        </form>
    </div>
</x-app-layout>
