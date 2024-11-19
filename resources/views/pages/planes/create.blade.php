<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Crear Nuevo Diagnóstico</h1>
        <form action="{{ route('diagnosticos.store') }}" method="POST">
            @csrf
            <!-- Peso -->
            <div class="mb-4">
                <label for="peso" class="block text-sm font-medium text-gray-700">Peso (kg)</label>
                <input type="number" step="0.01" id="peso" name="peso" class="form-input mt-1 block w-full"
                    placeholder="Ej: 70.5" required>
                @error('peso')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Altura -->
            <div class="mb-4">
                <label for="altura" class="block text-sm font-medium text-gray-700">Altura (cm)</label>
                <input type="number" id="altura" name="altura" class="form-input mt-1 block w-full"
                    placeholder="Ej: 175" required>
                @error('altura')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <!-- Zona Afectada -->
            <div class="mb-4">
                <label for="zona_afectada" class="block text-sm font-medium text-gray-700">Zona Afectada</label>
                <select id="zona_afectada" name="zona_afectada" class="form-select mt-1 block w-full" required>
                    <option value="" disabled selected>Selecciona una opción</option>
                    <option value="Rodilla">Rodilla</option>
                    <option value="Tobillo">Tobillo</option>
                    <option value="Hombro">Hombro</option>
                    <option value="Cadera">Cadera</option>
                    <option value="Espalda Baja">Espalda Baja</option>
                    <option value="Cuello">Cuello</option>
                    <option value="Muñeca">Muñeca</option>
                    <option value="Codo">Codo</option>
                    <option value="Pie">Pie</option>
                    <option value="Muslo">Muslo</option>
                </select>
                @error('zona_afectada')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nivel de Dolor -->
            <div class="mb-4">
                <label for="nivel_dolor" class="block text-sm font-medium text-gray-700">Nivel de Dolor (1-10)</label>
                <input type="number" id="nivel_dolor" name="nivel_dolor" class="form-input mt-1 block w-full" min="1"
                    max="10" placeholder="Ej: 7" required>
                @error('nivel_dolor')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Días con la Lesión -->
            <div class="mb-4">
                <label for="lesion_dias" class="block text-sm font-medium text-gray-700">Días con la Lesión</label>
                <input type="number" id="lesion_dias" name="lesion_dias" class="form-input mt-1 block w-full"
                    placeholder="Ej: 15" required>
                @error('lesion_dias')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="lesion_previa" class="block text-sm font-medium text-gray-700">¿Lesión Previa?</label>
                <select name="lesion_previa" id="lesion_previa" class="form-select mt-1 block w-full">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>
            <!-- Campo de Diagnóstico (rellenado automáticamente) -->
            <div class="mb-4">
                <label for="diagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                <textarea id="diagnostico" name="diagnostico" rows="3" class="form-textarea mt-1 block w-full"
                    placeholder="Diagnóstico sugerido" readonly required></textarea>
                @error('diagnostico')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                Guardar Diagnóstico
            </button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script type="module" src="{{ asset('js/diagnostico.js') }}"></script>

</x-app-layout>