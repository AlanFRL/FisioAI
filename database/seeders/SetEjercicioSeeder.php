<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Set;
use App\Models\Ejercicio;

class SetEjercicioSeeder extends Seeder
{
    public function run()
    {
        // Diagnósticos y ejercicios organizados por zona
        $zonesExercises = [
            "Rodilla" => [
                "Tendinitis rotuliana" => [
                    ["nombre" => "Estiramiento de cuádriceps", "descripcion" => "Estiramiento para reducir tensión en los cuádriceps.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "Evitar estirar hasta el dolor."],
                    ["nombre" => "Fortalecimiento isométrico", "descripcion" => "Contracción de cuádriceps sin movimiento.", "duracion" => 3, "repeticiones" => 3, "precauciones" => "No mantener la posición por más de 10 segundos."],
                ],
                "Lesión de menisco" => [
                    ["nombre" => "Deslizamientos de talón", "descripcion" => "Flexión y extensión controlada de rodilla.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "No forzar el rango de movimiento."],
                    ["nombre" => "Fortalecimiento de isquiotibiales", "descripcion" => "Ejercicio con banda elástica para isquiotibiales.", "duracion" => 3, "repeticiones" => 3, "precauciones" => "Asegurarse de mantener la espalda recta."],
                ],
                "Esguince de ligamento colateral medial" => [
                    ["nombre" => "Flexiones asistidas de rodilla", "descripcion" => "Flexión de rodilla con soporte.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "Usar soporte para evitar cargas excesivas."],
                    ["nombre" => "Elevaciones de pierna recta", "descripcion" => "Fortalecimiento de cuádriceps sin flexionar rodilla.", "duracion" => 3, "repeticiones" => 3, "precauciones" => "Evitar realizar el ejercicio si hay dolor."],
                ],
            ],
            "Muñeca" => [
                "Tendinitis de muñeca" => [
                    ["nombre" => "Flexión de muñeca hacia abajo", "descripcion" => "Flexión suave para aliviar tensión.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Evitar estirar más allá del rango cómodo."],
                    ["nombre" => "Flexión de muñeca hacia arriba", "descripcion" => "Flexión suave para aliviar tensión.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Evitar estirar más allá del rango cómodo."],
                    ["nombre" => "Estiramiento de extensores de muñeca con peso", "descripcion" => "Estiramiento de extensores para mejora de flexibilidad.", "duracion" => 2, "repeticiones" => 5, "precauciones" => "Evitar estirar hasta sentir dolor."],
                ],
                "Esguince de muñeca" => [
                    ["nombre" => "Flexión de muñeca hacia abajo", "descripcion" => "Flexión suave para aliviar tensión.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Evitar estirar más allá del rango cómodo."],
                    ["nombre" => "Estiramiento de extensores de muñeca con peso", "descripcion" => "Estiramiento de extensores para mejora de flexibilidad.", "duracion" => 2, "repeticiones" => 5, "precauciones" => "Evitar estirar hasta sentir dolor."],
                ],
                "Impacto carpiano agudo" => [
                    ["nombre" => "Flexión de muñeca hacia abajo", "descripcion" => "Flexión suave para aliviar tensión.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Evitar estirar más allá del rango cómodo."],
                    ["nombre" => "Flexión de muñeca hacia arriba", "descripcion" => "Flexión suave para aliviar tensión.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Evitar estirar más allá del rango cómodo."],
                ],
            ],
            "Hombro" => [
                "Bursitis subacromial" => [
                    ["nombre" => "Elevaciones laterales asistidas", "descripcion" => "Ejercicio para mejorar la movilidad en el hombro.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "No levantar el brazo por encima del nivel del hombro."],
                    ["nombre" => "Rotaciones externas con banda elástica", "descripcion" => "Fortalecimiento del manguito rotador.", "duracion" => 3, "repeticiones" => 12, "precauciones" => "Mantener el codo pegado al cuerpo."],
                ],
                "Tendinitis del manguito rotador" => [
                    ["nombre" => "Estiramiento de hombro cruzado", "descripcion" => "Estiramiento suave para aliviar tensión en el hombro.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "No forzar el brazo hacia adentro."],
                    ["nombre" => "Elevaciones frontales con banda elástica", "descripcion" => "Fortalecimiento de músculos estabilizadores del hombro.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Evitar movimientos rápidos o bruscos."],
                ],
                "Luxación de hombro" => [
                    ["nombre" => "Isométricos del hombro", "descripcion" => "Contracciones controladas para fortalecer sin movimiento.", "duracion" => 3, "repeticiones" => 5, "precauciones" => "Evitar forzar movimientos si hay dolor."],
                    ["nombre" => "Rotaciones internas asistidas", "descripcion" => "Movimientos suaves para recuperar rango de movimiento.", "duracion" => 2, "repeticiones" => 12, "precauciones" => "Realizar movimientos lentos y controlados."],
                ],
            ],
            "Codo" => [
                "Epicondilitis lateral (Codo de tenista)" => [
                    ["nombre" => "Estiramiento de extensores de codo", "descripcion" => "Estiramiento suave para aliviar tensión en el codo.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "Evitar estirar más allá del rango cómodo."],
                    ["nombre" => "Flexión de muñeca con mancuerna", "descripcion" => "Fortalecimiento de músculos del antebrazo.", "duracion" => 3, "repeticiones" => 12, "precauciones" => "Usar una mancuerna ligera."],
                ],
                "Epitrocleitis (Codo de golfista)" => [
                    ["nombre" => "Rotaciones de antebrazo con banda", "descripcion" => "Fortalecimiento de rotadores del antebrazo.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "No realizar movimientos bruscos."],
                    ["nombre" => "Extensión de muñeca con mancuerna", "descripcion" => "Fortalecimiento de extensores del antebrazo.", "duracion" => 3, "repeticiones" => 12, "precauciones" => "Realizar movimientos lentos."],
                ],
                "Bursitis olecraneana severa" => [
                    ["nombre" => "Ejercicios isométricos del codo", "descripcion" => "Fortalecimiento sin movimiento articular.", "duracion" => 3, "repeticiones" => 5, "precauciones" => "Evitar si hay inflamación activa."],
                    ["nombre" => "Extensiones controladas del codo", "descripcion" => "Mejora de la movilidad con movimientos suaves.", "duracion" => 2, "repeticiones" => 12, "precauciones" => "Evitar forzar el rango de movimiento."],
                ],
            ],
            "Tobillo" => [
                "Esguince leve de tobillo" => [
                    ["nombre" => "Movilidad de tobillo en círculos", "descripcion" => "Ejercicio para mejorar la movilidad articular.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Evitar movimientos bruscos."],
                    ["nombre" => "Flexión plantar con banda elástica", "descripcion" => "Fortalecimiento de músculos de la pantorrilla.", "duracion" => 3, "repeticiones" => 12, "precauciones" => "Usar una banda de resistencia ligera."],
                ],
                "Tendinitis de Aquiles" => [
                    ["nombre" => "Elevaciones de talones", "descripcion" => "Fortalecimiento controlado del tendón de Aquiles.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Realizar movimientos lentos y controlados."],
                    ["nombre" => "Estiramiento de pantorrilla contra la pared", "descripcion" => "Alivio de tensión en los músculos de la pantorrilla.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "No forzar el estiramiento más allá de lo cómodo."],
                ],
                "Esguince severo de tobillo" => [
                    ["nombre" => "Movilización activa de tobillo", "descripcion" => "Ejercicio para recuperar rango de movimiento.", "duracion" => 2, "repeticiones" => 12, "precauciones" => "No realizar si hay inflamación severa."],
                    ["nombre" => "Fortalecimiento con banda elástica", "descripcion" => "Ejercicio para mejorar estabilidad del tobillo.", "duracion" => 3, "repeticiones" => 12, "precauciones" => "Usar una banda de resistencia ligera al inicio."],
                ],
            ],
            "Cadera" => [
                "Bursitis trocantérica" => [
                    ["nombre" => "Estiramiento de abductores", "descripcion" => "Alivia la tensión en los músculos abductores.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Evitar rebotes durante el estiramiento."],
                    ["nombre" => "Fortalecimiento de glúteos con puente", "descripcion" => "Fortalecimiento de los músculos glúteos mediante elevaciones de cadera.", "duracion" => 3, "repeticiones" => 12, "precauciones" => "Mantener la espalda recta durante el ejercicio."],
                ],
                "Desgarro muscular en glúteos o aductores" => [
                    ["nombre" => "Elevaciones laterales de pierna", "descripcion" => "Fortalecimiento de los músculos abductores.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Realizar movimientos lentos y controlados."],
                    ["nombre" => "Masajes con rodillo de espuma", "descripcion" => "Ayuda a relajar los músculos aductores después del esfuerzo.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "Evitar masajear directamente sobre zonas con dolor agudo."],
                ],
            ],

            "Espalda Baja" => [
                "Lumbalgia mecánica" => [
                    ["nombre" => "Estiramiento de gato y camello", "descripcion" => "Ejercicio suave para movilizar la columna vertebral.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Evitar forzar la extensión o flexión."],
                    ["nombre" => "Plancha abdominal modificada", "descripcion" => "Fortalecimiento del core para dar soporte a la columna.", "duracion" => 3, "repeticiones" => 3, "precauciones" => "No realizar si causa dolor."],
                ],
                "Hernia discal lumbar leve" => [
                    ["nombre" => "Estiramiento de rodillas al pecho", "descripcion" => "Reduce la presión en la columna lumbar.", "duracion" => 2, "repeticiones" => 5, "precauciones" => "Realizar movimientos suaves y controlados."],
                    ["nombre" => "Puente lumbar", "descripcion" => "Fortalece los glúteos y reduce la carga en la espalda baja.", "duracion" => 3, "repeticiones" => 12, "precauciones" => "Evitar movimientos bruscos."],
                ],
                "Contractura muscular lumbar severa" => [
                    ["nombre" => "Estiramiento de esfinge", "descripcion" => "Alivia la tensión en la parte baja de la espalda.", "duracion" => 3, "repeticiones" => 5, "precauciones" => "Mantener una posición cómoda."],
                    ["nombre" => "Movilización pélvica en decúbito supino", "descripcion" => "Ayuda a relajar la zona lumbar.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Evitar realizar si hay inflamación severa."],
                ],
            ],

            "Cuello" => [
                "Distensión muscular cervical" => [
                    ["nombre" => "Estiramiento de cuello lateral", "descripcion" => "Alivia la tensión en los músculos del cuello.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "Realizar movimientos suaves y sin rebotes."],
                    ["nombre" => "Rotaciones controladas de cuello", "descripcion" => "Mejora la movilidad articular del cuello.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Evitar movimientos bruscos o rápidos."],
                ],
                "Latigazo cervical" => [
                    ["nombre" => "Retracción cervical", "descripcion" => "Ejercicio para alinear la columna cervical.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Realizar frente a un espejo para evitar posiciones incorrectas."],
                    ["nombre" => "Estiramiento de trapecios", "descripcion" => "Reduce la tensión en los trapecios superiores.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "Evitar forzar el estiramiento más allá del rango cómodo."],
                ],
                "Tortícolis severa" => [
                    ["nombre" => "Movilización activa de cuello", "descripcion" => "Movimientos suaves para recuperar movilidad.", "duracion" => 3, "repeticiones" => 5, "precauciones" => "Evitar realizar si causa dolor agudo."],
                    ["nombre" => "Estiramiento lateral asistido", "descripcion" => "Ejercicio para reducir la rigidez del cuello.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "Hacerlo con asistencia si hay limitación de movimiento."],
                ],
            ],
            "Pie" => [
                "Fascitis plantar" => [
                    ["nombre" => "Rodar pelota bajo el pie", "descripcion" => "Masaje suave para aliviar la tensión en la fascia plantar.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "No aplicar demasiada presión."],
                    ["nombre" => "Estiramiento de fascia plantar", "descripcion" => "Estiramiento controlado de la fascia plantar y dedos.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "Evitar estirar más allá del rango cómodo."],
                ],
                "Metatarsalgia" => [
                    ["nombre" => "Elevaciones de talones sentado", "descripcion" => "Fortalecimiento de los músculos del pie y pantorrilla.", "duracion" => 3, "repeticiones" => 12, "precauciones" => "Realizar movimientos controlados."],
                    ["nombre" => "Estiramiento de dedos del pie", "descripcion" => "Aumenta la flexibilidad de los músculos del pie.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "Evitar movimientos bruscos."],
                ],
                "Esguince de pie severo" => [
                    ["nombre" => "Flexión y extensión de pie con banda elástica", "descripcion" => "Fortalecimiento y recuperación de movilidad.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Usar una banda de resistencia ligera."],
                    ["nombre" => "Círculos de pie", "descripcion" => "Movilidad articular para recuperar rango de movimiento.", "duracion" => 3, "repeticiones" => 12, "precauciones" => "Realizar movimientos lentos y controlados."],
                ],
            ],

            "Muslo" => [
                "Distensión muscular leve" => [
                    ["nombre" => "Estiramiento de isquiotibiales", "descripcion" => "Reduce la tensión en los músculos isquiotibiales.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "No realizar si hay dolor agudo."],
                    ["nombre" => "Elevaciones de pierna recta", "descripcion" => "Fortalecimiento de los músculos del muslo sin flexionar la rodilla.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Mantener la espalda recta durante el ejercicio."],
                ],
                "Contusión muscular en cuádriceps" => [
                    ["nombre" => "Masaje con rodillo de espuma", "descripcion" => "Relaja y reduce la rigidez en los músculos del muslo.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "Evitar masajear sobre hematomas visibles."],
                    ["nombre" => "Flexión de rodilla asistida", "descripcion" => "Mejora la movilidad del muslo y rodilla.", "duracion" => 3, "repeticiones" => 10, "precauciones" => "Realizar con soporte para evitar lesiones adicionales."],
                ],
                "Desgarro muscular en isquiotibiales" => [
                    ["nombre" => "Isométricos de isquiotibiales", "descripcion" => "Fortalecimiento suave sin movimiento.", "duracion" => 3, "repeticiones" => 3, "precauciones" => "Evitar realizar si hay dolor intenso."],
                    ["nombre" => "Estiramiento suave de isquiotibiales", "descripcion" => "Alivia la tensión y mejora la flexibilidad.", "duracion" => 2, "repeticiones" => 3, "precauciones" => "No estirar más allá del rango cómodo."],
                ],
            ],
            // Agrega más zonas y diagnósticos siguiendo el formato...
        ];

        // Crear sets y ejercicios en la base de datos
        foreach ($zonesExercises as $zone => $diagnoses) {
            foreach ($diagnoses as $diagnosis => $exercises) {
                // Crear un set para el diagnóstico
                $set = Set::create([
                    'descripcion' => "Ejercicios para tratar {$diagnosis} en la zona {$zone}.",
                    'diagnostico' => $diagnosis,
                ]);

                // Crear o encontrar ejercicios y asociarlos al set
                foreach ($exercises as $exerciseData) {
                    $exercise = Ejercicio::firstOrCreate([
                        'nombre' => $exerciseData['nombre'],
                    ], $exerciseData);

                    $set->ejercicios()->attach($exercise->id);
                }
            }
        }
    }
}
