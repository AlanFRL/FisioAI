<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils/control_utils.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/holistic/holistic.js" crossorigin="anonymous"></script>

    <div class="container mx-auto px-4 py-8">
        <!-- Título -->
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-700">Información del Ejercicio</h1>

        <!-- Primera fila: Detalles del ejercicio y video/gif -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Detalles del Ejercicio -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Detalles del Ejercicio</h2>
                <p class="mb-2"><strong class="text-gray-600">Nombre:</strong> {{ $ejercicio->nombre }}</p>
                <p class="mb-2"><strong class="text-gray-600">Descripción:</strong> {{ $ejercicio->descripcion }}</p>
                <p class="mb-2"><strong class="text-gray-600">Duración:</strong> {{ $ejercicio->duracion }} series</p>
                <p class="mb-2"><strong class="text-gray-600">Repeticiones:</strong> {{ $ejercicio->repeticiones }}
                    repeticiones</p>
                <p><strong class="text-gray-600">Precauciones:</strong> {{ $ejercicio->precauciones }}</p>
            </div>

            <!-- Video o GIF -->
            <div class="bg-white p-6 rounded-lg shadow flex justify-center items-center">
                <img src="{{ asset('images/ejercicios/muneca_e9.gif') }}" alt="Ejemplo del Ejercicio"
                    class="w-full rounded-lg shadow-lg" width="640" height="480">
                <!-- Sustituye "images/example.gif" con la ruta de tu video o gif real -->
            </div>
        </div>

        <!-- Segunda fila: Cámara y Controles -->
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-700">Realización del Ejercicio</h1>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

            <!-- Información de la Realización -->
            <div class="bg-white p-6 rounded-lg shadow">
                <!-- Progreso -->
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Progreso</h2>
                <p class="mb-2"><strong class="text-gray-600">Ángulo:</strong> <span id="angle-value">0</span> grados
                </p>
                <p class="mb-2"><strong class="text-gray-600">Serie:</strong> <span id="current-series">0</span>/<span
                        id="total-series">2</span></p>
                <p class="mb-2"><strong class="text-gray-600">Repetición:</strong> <span
                        id="current-reps">0</span>/<span id="total-reps">15</span></p>

                <!-- Mensajes -->
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Mensajes</h2>
                <p id="exercise-message" class="mb-2 text-blue-500">Mantenga la mano en posición indicada.</p>
                <p id="warning" class="mb-2 text-red-500" style="display: none;">Use solo una mano.</p>
                <p id="completion-message" class="mb-2 text-green-500" style="display: none;">¡Ejercicio completado!</p>
                <p class="mb-2"><strong class="text-gray-600">Precisión:</strong> <span id="precision-value">0</span> %
                </p>
                <!-- Contenedor para mensajes visuales -->
                <div id="message-container" style="position: fixed; top: 10px; right: 10px; width: 300px; z-index: 9999;"></div>


                <!-- Controles -->
                <div class="mt-6 flex justify-center space-x-4">
                    <button id="toggle-camera"
                        class="btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Activar Cámara
                    </button>
                    <a href="javascript:void(0);" id="save-results"
                        class="btn bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg"
                        style="display: none;" onclick="guardarResultado()">
                        Guardar Resultado
                    </a>
                </div>
            </div>

            <!-- Canvas -->
            <div class="bg-white p-6 rounded-lg shadow flex justify-center items-center">
                <!-- Video (oculto) -->
                <video id="input_video" class="input_video hidden" autoplay muted playsinline></video>
                <!-- Canvas (visible)  -->
                <canvas id="output_canvas" class="output_canvas w-full rounded-lg shadow-lg" width="640"
                    height="480">></canvas>
            </div>
        </div>
    </div>

    <!-- Pasar los IDs como atributos de un contenedor -->
    <div id="exercise-data" data-tratamiento-id="{{ $tratamientoId }}" data-ejercicio-id="{{ $ejercicioId }}"
        data-guardar-ruta="{{ route('guardar-resultado') }}" data-serie="{{ $ejercicio->duracion }}" data-rep="{{ $ejercicio->repeticiones }}">
    </div>

    <script type="module" src="{{ asset('js/codo_e12/exercise.js') }}"></script>
</x-app-layout>