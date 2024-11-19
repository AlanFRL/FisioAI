<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils/control_utils.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/holistic/holistic.js" crossorigin="anonymous"></script>

    <div class="container">
        <!-- Video ocupa toda el área -->
        <video class="input_video" autoplay muted playsinline
        width="640" height="480"></video>
        <!-- Canvas se superpone al video -->
        <canvas class="output_canvas" width="640" height="480"></canvas>
    </div>

    <div class="info">
        <div class="angle-display">Ángulo: <span id="angle-value">0</span> grados</div>
        <div class="series-repetitions">Serie: <span id="current-series">0</span>/<span id="total-series">3</span>, Repetición: <span id="current-reps">0</span>/<span id="total-reps">15</span></div>
        <div id="warning" style="color: red; display: none;">Solo use una mano</div>
        <div id="completion-message" style="color: green; display: none;">¡Ejercicio completado!</div>
    </div>

    <div class="controls">
        <button id="toggle-camera" class="btn btn-primary">Activar cámara</button>
    </div>

    <script type="module" src="{{ asset('js/muneca.js') }}"></script>
</x-app-layout>