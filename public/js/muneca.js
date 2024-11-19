// Suponiendo que el servidor puede resolver estos módulos correctamente
import { calculateWristFlexion } from './calculations.js';

const videoElement = document.querySelector('.input_video');        //Entrada de Video
const canvasElement = document.querySelector('.output_canvas');     //Aquí se dibujan los frames y puntos
const canvasCtx = canvasElement.getContext('2d');                   
const angleDisplay = document.getElementById('angle-value');        //Aquí se muestra el ángulo de la muñeca
const seriesDisplay = document.getElementById('current-series');        //Cantidad de series realizadas
const totalSeriesDisplay = document.getElementById('total-series');     //Cantidad de series por hacer
const repetitionsDisplay = document.getElementById('current-reps');     //Cantidad de repeticiones realizadas
const totalRepsDisplay = document.getElementById('total-reps');         //Cantidad de repeticiones por hacer
const warningMessage = document.getElementById('warning');              //Mensaje de advertencia por usar 2 manos
const completionMessage = document.getElementById('completion-message');    //Mensaje indicador de ejercicio completado
const toggleCameraButton = document.getElementById('toggle-camera');        //Botón de la cámara


let camera = null;
let holistic = null;

// Configuración de series y repeticiones
const totalSeries = 3;
const totalReps = 15;
let currentSeries = 0;
let currentReps = 0;


// Oculta el elemento <video> para que no sea visible
videoElement.style.display = 'none';

// Controles de estado
let isFlexing = false;      // Estado para evitar múltiples conteos de una flexión
let cameraActive = false;

totalSeriesDisplay.textContent = totalSeries;
totalRepsDisplay.textContent = totalReps;

holistic = new Holistic({
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
    canvasCtx.drawImage(results.image, 0, 0, canvasElement.width, canvasElement.height);

    const { poseLandmarks, rightHandLandmarks, leftHandLandmarks } = results;

    // Validar que solo haya una mano visible
    const handsDetected = (rightHandLandmarks ? 1 : 0) + (leftHandLandmarks ? 1 : 0);
    if (handsDetected > 1) {
        warningMessage.style.display = 'block';
        return;
    } else {
        warningMessage.style.display = 'none';
    }

    const hand = rightHandLandmarks || leftHandLandmarks;
    const isRightHand = Boolean(rightHandLandmarks);

    if (poseLandmarks && hand) {
        const elbow = isRightHand ? poseLandmarks[14] : poseLandmarks[13];
        const wrist = isRightHand ? poseLandmarks[16] : poseLandmarks[15];
        const fingerTip = isRightHand ? hand[8] : hand[8];

        // Dibujar conexiones manualmente
        canvasCtx.beginPath();
        canvasCtx.moveTo(elbow.x * canvasElement.width, elbow.y * canvasElement.height);
        canvasCtx.lineTo(wrist.x * canvasElement.width, wrist.y * canvasElement.height);
        canvasCtx.lineTo(fingerTip.x * canvasElement.width, fingerTip.y * canvasElement.height);
        canvasCtx.strokeStyle = '#00FF00';
        canvasCtx.lineWidth = 4;
        canvasCtx.stroke();

        // Dibujar puntos
        [elbow, wrist, fingerTip].forEach(point => {
            canvasCtx.beginPath();
            canvasCtx.arc(point.x * canvasElement.width, point.y * canvasElement.height, 5, 0, 2 * Math.PI);
            canvasCtx.fillStyle = '#FF0000';
            canvasCtx.fill();
        });

        const angle = calculateWristFlexion(elbow, wrist, fingerTip);
        angleDisplay.textContent = `${angle.toFixed(2)}`; // Mostrar ángulo

        // Detectar flexión
        if (angle < 30 && !isFlexing) {
            isFlexing = true;
        }
        if (angle > 65 && isFlexing) {
            currentReps++;
            repetitionsDisplay.textContent = currentReps;
            isFlexing = false;

            // Verificar si se completaron las repeticiones de la serie
            if (currentReps >= totalReps) {
                currentSeries++;
                seriesDisplay.textContent = currentSeries;
                currentReps = 0;
                repetitionsDisplay.textContent = currentReps;

                if (currentSeries >= totalSeries) {
                    completionMessage.style.display = 'block';
                    stopCamera();
                } else {
                    alert(`Pausa completada. Prepárate para la serie ${currentSeries + 1}`);
                }
            }
        }
    }
});

// Función para alternar la cámara
function toggleCamera() {
    if (cameraActive) {
        stopCamera();
    } else {
        startCamera();
    }
}

// Iniciar la cámara
function startCamera() {
    if (!camera) {
        camera = new Camera(videoElement, {
            onFrame: async () => {
                await holistic.send({ image: videoElement });
            },
            width: 640,
            height: 480
        });
    }
    camera.start();
    cameraActive = true;
    toggleCameraButton.textContent = 'Desactivar cámara';
}

// Detener la cámara
function stopCamera() {
    if (camera) {
        camera.stop();
    }
    cameraActive = false;
    toggleCameraButton.textContent = 'Activar cámara';
}

toggleCameraButton.addEventListener('click', toggleCamera);
