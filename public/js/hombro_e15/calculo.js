// Variables globales

let isFlexed = false; // Estado actual del brazo (flexionado o no)
let repetitions = 0; // Contador de repeticiones

/**
 * Verifica si el usuario está en la posición inicial.
 * @param {Object} shoulder - Coordenadas del hombro {x, y}.
 * @param {Object} elbow - Coordenadas del codo {x, y}.
 * @param {Object} wrist - Coordenadas de la muñeca {x, y}.
 * @returns {boolean} - True si el usuario está en posición inicial, False si no.
 */
const repetitionDisplay = document.getElementById('repetition-count'); // Para mostrar el contador de repeticiones
export function isInInitialPosition(shoulder, elbow, wrist) {
    const calculateDistance = (pointA, pointB) => {
        return Math.sqrt(Math.pow(pointB.x - pointA.x, 2) + Math.pow(pointB.y - pointA.y, 2));
    };

    const shoulderToElbow = calculateDistance(shoulder, elbow);
    const elbowToWrist = calculateDistance(elbow, wrist);

    const angleRadians = Math.acos(
        (Math.pow(shoulderToElbow, 2) + Math.pow(elbowToWrist, 2) - Math.pow(calculateDistance(shoulder, wrist), 2)) /
        (2 * shoulderToElbow * elbowToWrist)
    );
    const angleDegrees = (angleRadians * 180) / Math.PI;

    const isAngleCorrect = Math.abs(angleDegrees - 90) <= 15; // Ángulo cerca de 90° con tolerancia
    const isDistanceValid = shoulderToElbow > 0.2 && elbowToWrist > 0.2;

    return isAngleCorrect && isDistanceValid;
}

/**
 * Monitorea y cuenta repeticiones basado en la flexión del brazo.
 * @param {Object} elbow - Coordenadas del codo {x, y}.
 * @param {Object} wrist - Coordenadas de la muñeca {x, y}.
 */
export function countRepetitions(elbow, wrist, repetitionDisplay) {
    
    const calculateDistance = (pointA, pointB) => {
        return Math.sqrt(Math.pow(pointB.x - pointA.x, 2) + Math.pow(pointB.y - pointA.y, 2));
    };

    const currentDistance = calculateDistance(elbow, wrist);
    console.log(currentDistance);
    // Detecta si el brazo pasa de extendido a flexionado
    if (currentDistance < 0.2 && !isFlexed) {
        // Si la distancia es corta (brazo flexionado) y antes estaba extendido
        isFlexed = true;
        
    } else if (currentDistance >= 0.4 && isFlexed) {
        // Si la distancia vuelve a ser larga (brazo extendido)
        repetitions++;
        repetitionDisplay.textContent = `Repeticiones: ${repetitions}`;
        console.log(`Repetición detectada: ${repetitions}`);
        isFlexed = false;
    }
}

export function resetRepetitions() {
    repetitions = 0;
}