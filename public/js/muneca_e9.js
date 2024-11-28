import { calculatePrecision, showVisualMessage, calculateWristFlexion } from './helpers.js';

const videoElement = document.getElementById('input_video');        //Entrada de Video
const canvasElement = document.getElementById('output_canvas');     //Aquí se dibujan los frames y puntos
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

    const { poseLandmarks, rightHandLandmarks, leftHandLandmarks } = results;

    // Validar que solo haya una mano visible
    const handsDetected = (rightHandLandmarks ? 1 : 0) + (leftHandLandmarks ? 1 : 0);
    if (handsDetected > 1) {
        warningMessage.style.display = 'block';
        //showVisualMessage("Utiliza solo una mano.", "error");
        return;
    } else {
        warningMessage.style.display = 'none';
    }

    const hand = rightHandLandmarks || leftHandLandmarks;
    const isRightHand = Boolean(rightHandLandmarks);

    if (poseLandmarks && hand) {
        const elbow = isRightHand ? poseLandmarks[14] : poseLandmarks[13];
        const wrist = isRightHand ? poseLandmarks[16] : poseLandmarks[15];
        const fingerTip = isRightHand ? hand[4] : hand[4];

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

        // Validar posición inicial
        if (!exerciseStarted) {
            if (angle > 50 && angle < 75) {
                keypointsDetected++;
                if (keypointsDetected >= 60) { // 5 segundos de detección continua
                    exerciseStarted = true;
                    exerciseMessage.textContent = 'Ejercicio iniciado. Proceda con las repeticiones.';
                    showVisualMessage("Ejercicio iniciado. Proceda con las repeticiones.");
                }
            } else {
                keypointsDetected = 0;
            }
        }

        if (exerciseStarted) {
            // Detectar flexión
            if (angle > 40 && !isFlexing) {
                isFlexing = true;
            }
            if (angle < 10 && isFlexing) {
                const currentTime = Date.now();     //Obtiene el tiempo actual

                // Evaluar tiempo entre repeticiones
                if (lastRepTime !== null) {
                    const elapsedTime = (currentTime - lastRepTime) / 1000; // En segundos
                    timeBetweenReps.push(elapsedTime);

                    if (elapsedTime < 2) {
                        incorrectReps++;
                        showVisualMessage("Repetición muy rápida.", "error");
                    } else if (elapsedTime > 5) {
                        incorrectReps++;
                        showVisualMessage("Repetición muy lenta.", "error");
                    } else {
                        correctReps++;
                    }
                } else {
                    correctReps++; // Primera repetición siempre se considera correcta
                }
                lastRepTime = currentTime;



                // Actualizar repetición y serie
                currentReps++;
                repetitionsDisplay.textContent = currentReps;
                isFlexing = false;

                // Verificar si se completaron las repeticiones de la serie
                if (currentReps >= totalReps) {
                    currentSeries++;
                    seriesDisplay.textContent = currentSeries;
                    currentReps = 0;
                    repetitionsDisplay.textContent = currentReps;
                    lastRepTime = null;

                    if (currentSeries >= totalSeries) {
                        completionMessage.style.display = 'block';          //Mostrar mensaje de ejercicio completo
                        toggleCameraButton.style.display = 'none';          // Ocultar botón de cámara
                        saveResultButton.style.display = 'inline-block';    //Mostrar botón de guardar
                        stopCamera();

                        precision = calculatePrecision(
                            correctReps, 
                            incorrectReps, 
                            tratamientoId, 
                            ejercicioId
                        );
                        precisionDisplay.textContent = `${precision}`;
                    } else {
                        showVisualMessage(`Serie completada. Prepárate para la serie ${currentSeries + 1}`);
                    }
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

function guardarResultado() {
    // Redirigir a la ruta con los parámetros
    const url = `${guardarRuta}?tratamiento_id=${tratamientoId}&ejercicio_id=${ejercicioId}&porcentaje_precision=${precision}`;
    window.location.href = url;
}

// Hacer la función accesible globalmente
window.guardarResultado = guardarResultado;