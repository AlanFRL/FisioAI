// Suponiendo que el servidor puede resolver estos módulos correctamente
import { calculateWristFlexion } from './calculations.js';

const videoElement = document.querySelector('.input_video');
const canvasElement = document.querySelector('.output_canvas');
const canvasCtx = canvasElement.getContext('2d');
const angleDisplay = document.getElementById('angle-value');

// Oculta el elemento <video> para que no sea visible
videoElement.style.display = 'none';

// Referencias a los botones en la vista
const startButton = document.getElementById('start-camera');
const stopButton = document.getElementById('stop-camera');

const holistic = new Holistic({
    locateFile: file => `https://cdn.jsdelivr.net/npm/@mediapipe/holistic/${file}`
});
holistic.setOptions({
    modelComplexity: 1,
    smoothLandmarks: true,
    enableSegmentation: false,
    smoothSegmentation: false,
    refineFaceLandmarks: false,
    minDetectionConfidence: 0.5,
    minTrackingConfidence: 0.5
});

holistic.onResults(results => {
    canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
    // Dibuja la imagen de la cámara en el canvas
    canvasCtx.drawImage(results.image, 0, 0, canvasElement.width, canvasElement.height);
    // Dibuja los keypoints sobre la imagen de la cámara
    if (results.poseLandmarks) {
        drawConnectors(canvasCtx, results.poseLandmarks, POSE_CONNECTIONS, { color: '#00FF00', lineWidth: 4 });
        drawLandmarks(canvasCtx, results.poseLandmarks, { color: '#FF0000', lineWidth: 2 });

        const angle = calculateWristFlexion(results.poseLandmarks);
        angleDisplay.textContent = `${angle.toFixed(2)}`; // Mostrar el ángulo calculado
    }
});

const camera = new Camera(videoElement, {
    onFrame: async () => {
        await holistic.send({ image: videoElement });
    },
    width: 640,
    height: 480
});

// Iniciar la cámara
startButton.addEventListener('click', () => {
    camera.start();
    console.log('Cámara iniciada');
});

// Detener la cámara
stopButton.addEventListener('click', () => {
    camera.stop();
    console.log('Cámara detenida');
});
