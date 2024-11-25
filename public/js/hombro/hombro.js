// Suponiendo que el servidor puede resolver estos módulos correctamente
import { isInInitialPosition,countRepetitions } from './calculo.js';

const videoElement = document.querySelector('.input_video');
const canvasElement = document.querySelector('.output_canvas');
const canvasCtx = canvasElement.getContext('2d');
// Referencias a los elementos en pantalla
const angleDisplay = document.getElementById('angle-value');
const positionDisplay = document.getElementById('position-status'); // Nueva referencia
const repetitionDisplay = document.getElementById('repetition-count'); // Nueva referencia
let initialPositionConfirmed = false;

// Oculta el elemento <video> para que no sea visible
videoElement.style.display = 'none';

// Referencias a los botones en la vista
const startButton = document.getElementById('start-camera');
const stopButton = document.getElementById('stop-camera');

const holistic = new Holistic({
    locateFile: file => `https://cdn.jsdelivr.net/npm/@mediapipe/holistic/${file}`
});
holistic.setOptions({
    modelComplexity: 2,
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

        const shoulder = results.poseLandmarks[12]; // Hombro derecho
        const elbow = results.poseLandmarks[14];   // Codo derecho
        const wrist = results.poseLandmarks[16];   // Muñeca derecha
         // Verifica si ya está en la posición inicial

        if (!initialPositionConfirmed) {
            // Verificar si está en la posición inicial
            initialPositionConfirmed = isInInitialPosition(shoulder, elbow, wrist);
            if (initialPositionConfirmed) {
                positionDisplay.textContent = 'Posición inicial confirmada'; // Muestra la confirmación
                console.log('Posición inicial confirmada. Comienza el ejercicio.');
            } else {
                positionDisplay.textContent = 'Colócate en la posición inicial'; // Mensaje de guía
            }
        } else {
            // console.log('entra')
            // Contar repeticiones si la posición inicial ya fue confirmada
            countRepetitions(elbow, wrist, repetitionDisplay);
        }
        // Verifica si el brazo está en posición horizontal
        // const isHorizontal = isArmExtended(shoulder, elbow, wrist);

        // // Muestra el resultado en pantalla
        // angleDisplay.textContent = isHorizontal
        //     ? 'Brazo en posición horizontal'
        //     : 'Brazo fuera de posición';

        // const angle = calculateWristFlexion(results.poseLandmarks);
        // angleDisplay.textContent = isArmInHorizontalPosition(shoulder, elbow, wrist) // Mostrar el ángulo calculado
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
