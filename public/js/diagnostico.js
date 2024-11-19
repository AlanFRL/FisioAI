let model;

// Cargar el modelo TensorFlow.js
async function loadModel() {
    model = await tf.loadGraphModel('/models/model.json'); // Ajusta la ruta si es necesario
    console.log("Modelo cargado exitosamente:", model);
}

// Realizar una predicción
async function realizarPrediccion() {
    // Obtener los valores del formulario
    const zonaAfectada = document.querySelector('#zona_afectada').value;
    const nivelDolor = parseFloat(document.querySelector('#nivel_dolor').value);
    const lesionDias = parseFloat(document.querySelector('#lesion_dias').value);

    console.log("Valores del formulario:");
    console.log("Zona afectada:", zonaAfectada);
    console.log("Nivel de dolor:", nivelDolor);
    console.log("Días con lesión:", lesionDias);

    if (!zonaAfectada || isNaN(nivelDolor) || isNaN(lesionDias)) {
        alert('Por favor, completa todos los campos.');
        return;
    }

    // Mapear la zona afectada a un índice (esto debe coincidir con tu modelo)
    const zonas = ["Cadera", "Codo", "Cuello", "Espalda Baja", "Hombro", "Muslo", "Muñeca", "Pie", "Rodilla", "Tobillo"];
    const zonaIndex = zonas.indexOf(zonaAfectada);

    if (zonaIndex === -1) {
        alert('Zona afectada inválida.');
        return;
    }

    console.log("Índice de zona afectada:", zonaIndex);

    // Crear el tensor de entrada
    const inputTensor = tf.tensor2d([[zonaIndex, nivelDolor, lesionDias]]);
    console.log("Tensor de entrada:", inputTensor);

    // Realizar la predicción
    const prediction = model.predict(inputTensor);
    console.log("Predicción bruta:", prediction);

    // Obtener el diagnóstico con mayor probabilidad
    const predictedIndex = prediction.argMax(1).dataSync()[0];
    console.log("Índice predicho:", predictedIndex);

    // Mapeo de índices a diagnósticos
    const diagnosticos = [
        'Bursitis olecraneana severa',
        'Bursitis subacromial',
        'Bursitis trocantérica',
        'Contractura muscular lumbar severa',
        'Contusión muscular en cuádriceps',
        'Desgarro muscular en glúteos o aductores',
        'Desgarro muscular en isquiotibiales',
        'Distensión muscular cervical',
        'Distensión muscular leve',
        'Epicondilitis lateral (Codo de tenista)',
        'Epitrocleitis (Codo de golfista)',
        'Esguince de ligamento colateral medial',
        'Esguince de muñeca',
        'Esguince de pie severo',
        'Esguince leve de tobillo',
        'Esguince severo de tobillo',
        'Fascitis plantar',
        'Hernia discal lumbar leve',
        'Impacto carpiano agudo',
        'Latigazo cervical',
        'Lesión de menisco',
        'Lumbalgia mecánica',
        'Luxación de hombro',
        'Metatarsalgia',
        'Tendinitis de Aquiles',
        'Tendinitis de muñeca',
        'Tendinitis del manguito rotador',
        'Tendinitis rotuliana',
        'Tortícolis severa'
    ];
    const diagnosticoPredicho = diagnosticos[predictedIndex];
    console.log("Diagnóstico predicho:", diagnosticoPredicho);

    // Mostrar el resultado
    document.querySelector('#diagnostico').value = diagnosticoPredicho;
    alert(`Diagnóstico sugerido: ${diagnosticoPredicho}`);
}

// Cargar el modelo al cargar la página
document.addEventListener('DOMContentLoaded', loadModel);

// Asociar el botón al evento de predicción
document.querySelectorAll('#nivel_dolor, #lesion_dias, #zona_afectada').forEach(element => {
    element.addEventListener('change', realizarPrediccion);
});