// Mostrar mensaje visual
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

// Calcular Precisión
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

// Calcular ángulo de la muñeca
export function calculateWristFlexion(elbow, wrist, fingerTip) {
    // Calcular los vectores entre los puntos
    const vector1 = [wrist.x - elbow.x, wrist.y - elbow.y];
    const vector2 = [fingerTip.x - wrist.x, fingerTip.y - wrist.y];

    // Producto punto y magnitudes
    const dotProduct = vector1[0] * vector2[0] + vector1[1] * vector2[1];
    const magnitude1 = Math.sqrt(vector1[0] ** 2 + vector1[1] ** 2);
    const magnitude2 = Math.sqrt(vector2[0] ** 2 + vector2[1] ** 2);

    // Ángulo en radianes, convertido a grados
    const angle = Math.acos(dotProduct / (magnitude1 * magnitude2)) * (180 / Math.PI);
    return angle;
}
