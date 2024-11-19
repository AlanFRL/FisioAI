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

    <div class="angle-display">Ángulo: <span id="angle-value">0</span> grados</div>
    <div class="controls">
        <button id="start-camera" class="btn btn-primary">Start Camera</button>
        <button id="stop-camera" class="btn btn-secondary">Stop Camera</button>
    </div>

    <script type="module" src="{{ asset('js/muneca.js') }}"></script>
</x-app-layout>