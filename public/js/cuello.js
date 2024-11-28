import { calculatePrecision, showVisualMessage, calculateWristFlexion } from './munecahelpers.js';

const videoElement = document.getElementById('input_video');        //Entrada de Video
const canvasElement = document.getElementById('output_canvas');     //Aquí se dibujan los frames y puntos
//const videoElement = document.querySelector('.input_video');        //Entrada de Video
//const canvasElement = document.querySelector('.output_canvas');     //Aquí se dibujan los frames y puntos
const canvasCtx = canvasElement.getContext('2d');
const angleDisplay = document.getElementById('angle-value');        //Aquí se muestra el ángulo de la muñeca
const seriesDisplay = document.getElementById('current-series');        //Cantidad de series realizadas
const totalSeriesDisplay = document.getElementById('total-series');     //Cantidad de series por hacer
const repetitionsDisplay = document.getElementById('current-reps');     //Cantidad de repeticiones realizadas
const totalRepsDisplay = document.getElementById('total-reps');         //Cantidad de repeticiones por hacer
const warningMessage = document.getElementById('warning');              //Mensaje de advertencia por usar 2 manos
const completionMessage = document.getElementById('completion-message');    //Mensaje indicador de ejercicio completado
const exerciseMessage = document.getElementById('exercise-message');        //Mensaje de indicación para comenzar en 5 segundos
const toggleCameraButton = document.getElementById('toggle-camera');        //Botón de la cámara
const saveResultButton = document.getElementById('save-results');            //Botón para guardar resultados
const precisionDisplay = document.getElementById('precision-value');        //Aquí se muestra el ángulo de la muñeca
// Leer IDs y valores desde la vista
const exerciseData = document.getElementById('exercise-data');
const tratamientoId = exerciseData.dataset.tratamientoId;
const ejercicioId = exerciseData.dataset.ejercicioId;
const guardarRuta = exerciseData.dataset.guardarRuta; // Obtiene la ruta
const serie = exerciseData.dataset.serie; // Obtiene la serie
const repeticiones = exerciseData.dataset.rep; // Obtiene las repeticiones
// Oculta el elemento <video> para que no sea visible
videoElement.style.display = 'none';

let camera = null;
let holistic = null;

// Configuración de series y repeticiones
const totalSeries = serie;
const totalReps = repeticiones;
//const totalSeries = 1;
//const totalReps = 5;
let currentSeries = 0;
let currentReps = 0;

totalSeriesDisplay.textContent = totalSeries;
totalRepsDisplay.textContent = totalReps;

// Control de precisión y flujo
let isFlexing = false;      // Estado para evitar múltiples conteos de una flexión
let cameraActive = false;
let exerciseStarted = false; // Indica si el ejercicio ha comenzado oficialmente
let keypointsDetected = 0; // Contador para validar la posición inicial correcta

// Variables para la precisión
let correctReps = 0; // Repeticiones correctas
let incorrectReps = 0; // Repeticiones incorrectas
let timeBetweenReps = []; // Tiempos entre repeticiones
let lastRepTime = null; // Tiempo de la última repetición
let precision = 0;

holistic = new Holistic({
    locateFile: file => `https://cdn.jsdelivr.net/npm/@mediapipe/holistic/${file}`
});
holistic.setOptions({
    modelComplexity: 2,
    smoothLandmarks: true,
    enableSegmentation: false,
    minDetectionConfidence: 0.5,
    minTrackingConfidence: 0.5
});


holistic.onResults(results => {
    canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
    canvasCtx.drawImage(results.image, 0, 0, canvasElement.width, canvasElement.height);

    const { poseLandmarks, faceLandmarks } = results;

    if (poseLandmarks && faceLandmarks) {
        // Extraer los puntos del cuello y mandíbula
        const neck = poseLandmarks[9]; // Punto del cuello
        const chin = faceLandmarks[152]; // Punto en la mandíbula inferior (mentón)

        // Dibujar el punto del cuello
        if (neck) {
            canvasCtx.beginPath();
            canvasCtx.arc(neck.x * canvasElement.width, neck.y * canvasElement.height, 5, 0, 2 * Math.PI);
            canvasCtx.fillStyle = '#FF0000';
            canvasCtx.fill();
        }

        // Dibujar el punto del mentón
        if (chin) {
            canvasCtx.beginPath();
            canvasCtx.arc(chin.x * canvasElement.width, chin.y * canvasElement.height, 5, 0, 2 * Math.PI);
            canvasCtx.fillStyle = '#FF0000';
            canvasCtx.fill();
        }

        // Dibujar una línea desde el mentón al cuello
        if (neck && chin) {
            canvasCtx.beginPath();
            canvasCtx.moveTo(chin.x * canvasElement.width, chin.y * canvasElement.height);
            canvasCtx.lineTo(neck.x * canvasElement.width, neck.y * canvasElement.height);
            canvasCtx.strokeStyle = '#00FF00';
            canvasCtx.lineWidth = 2;
            canvasCtx.stroke();
        }

        // Puntos adicionales (por ejemplo, mandíbula izquierda y derecha)
        const jawLeft = faceLandmarks[234]; // Lado izquierdo de la mandíbula
        const jawRight = faceLandmarks[454]; // Lado derecho de la mandíbula

        // Dibujar puntos de la mandíbula izquierda y derecha
        [jawLeft, jawRight].forEach(point => {
            if (point) {
                canvasCtx.beginPath();
                canvasCtx.arc(point.x * canvasElement.width, point.y * canvasElement.height, 5, 0, 2 * Math.PI);
                canvasCtx.fillStyle = '#FF0000';
                canvasCtx.fill();
            }
        });

        // Dibujar líneas desde el mentón a la mandíbula izquierda y derecha
        if (chin && jawLeft) {
            canvasCtx.beginPath();
            canvasCtx.moveTo(chin.x * canvasElement.width, chin.y * canvasElement.height);
            canvasCtx.lineTo(jawLeft.x * canvasElement.width, jawLeft.y * canvasElement.height);
            canvasCtx.strokeStyle = '#FF0000';
            canvasCtx.lineWidth = 2;
            canvasCtx.stroke();
        }
        if (chin && jawRight) {
            canvasCtx.beginPath();
            canvasCtx.moveTo(chin.x * canvasElement.width, chin.y * canvasElement.height);
            canvasCtx.lineTo(jawRight.x * canvasElement.width, jawRight.y * canvasElement.height);
            canvasCtx.strokeStyle = '#FF0000';
            canvasCtx.lineWidth = 2;
            canvasCtx.stroke();
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

function guardarResultado() {
    // Redirigir a la ruta con los parámetros
    const url = `${guardarRuta}?tratamiento_id=${tratamientoId}&ejercicio_id=${ejercicioId}&porcentaje_precision=${precision}`;
    window.location.href = url;
}

// Hacer la función accesible globalmente
window.guardarResultado = guardarResultado;
