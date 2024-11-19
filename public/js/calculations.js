export function calculateWristFlexion(landmarks) {
    // Identificar landmarks específicos (se asume que estos son índices de la muñeca y el codo)
    const wrist = landmarks[15]; // Landmark de la muñeca
    const elbow = landmarks[13]; // Landmark del codo
    const shoulder = landmarks[11]; // Landmark del hombro
  
    // Calcular el ángulo (esta es una simplificación, considera la anatomía específica y ajusta según sea necesario)
    const angle = Math.atan2(wrist.y - elbow.y, wrist.x - elbow.x) - Math.atan2(shoulder.y - elbow.y, shoulder.x - elbow.x);
    return angle * (180 / Math.PI);
  }
  