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
