// Variables globales
let repetitions = 0;
let isFlexed = false;


export function showVisualMessage(message, type = 'info') {
    const container = document.querySelector("#message-container");

    if (container) {
        const messageDiv = document.createElement("div");
        messageDiv.textContent = message;
        messageDiv.style.padding = "10px";
        messageDiv.style.marginBottom = "10px";
        messageDiv.style.borderRadius = "5px";
        messageDiv.style.color = "#fff";
        messageDiv.style.backgroundColor = type === 'error' ? "#dc3545" : "#28a745";

        container.appendChild(messageDiv);

        setTimeout(() => messageDiv.remove(), 3000);
    }
}

/**
 * Verifica si el usuario está en la posición inicial.
 */
export function isInInitialPosition(shoulder, elbow, wrist) {
    const calculateDistance = (pointA, pointB) => Math.sqrt(
        Math.pow(pointB.x - pointA.x, 2) + Math.pow(pointB.y - pointA.y, 2)
    );

    const shoulderToElbow = calculateDistance(shoulder, elbow);
    const elbowToWrist = calculateDistance(elbow, wrist);

    const angleRadians = Math.acos(
        (Math.pow(shoulderToElbow, 2) + Math.pow(elbowToWrist, 2) - Math.pow(calculateDistance(shoulder, wrist), 2)) /
        (2 * shoulderToElbow * elbowToWrist)
    );
    const angleDegrees = (angleRadians * 180) / Math.PI;

    return Math.abs(angleDegrees - 90) <= 15 && shoulderToElbow > 0.2 && elbowToWrist > 0.2;
}

export function calculatePrecision(correctReps, incorrectReps, tratamientoId, ejercicioId) {
    const totalReps = correctReps + incorrectReps;
    // Calcular precisión
    const precision = totalReps > 0 ? (correctReps / totalReps) * 100 : 0;

    // Mostrar resultados al usuario
    showVisualMessage(`Ejercicio completado. Precisión: ${precision.toFixed(2)}%`);

    console.log({
        tratamiento_id: tratamientoId,
        ejercicio_id: ejercicioId,
        fecha: new Date().toISOString().split('T')[0],
        precision
    });

    return precision;
}
/**
 * Cuenta las repeticiones basado en la flexión del brazo.
 */
export function countRepetitions(elbow, wrist, repetitionDisplay) {
    const calculateDistance = (pointA, pointB) => Math.sqrt(
        Math.pow(pointB.x - pointA.x, 2) + Math.pow(pointB.y - pointA.y, 2)
    );

    const currentDistance = calculateDistance(elbow, wrist);

    if (currentDistance < 0.2 && !isFlexed) {
        isFlexed = true;
    } else if (currentDistance >= 0.4 && isFlexed) {
        repetitions++;
        repetitionDisplay.textContent = repetitions;
        isFlexed = false;
    }
}
