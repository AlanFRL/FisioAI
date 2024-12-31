<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Progreso General</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Reporte de Progreso General</h1>
    <p><strong>Fecha del Reporte:</strong> {{ $fechaGeneracion }}</p>
    <p><strong>Usuario:</strong> {{ $user->name }}</p>
    <p><strong>Edad:</strong> {{ $edad }} años</p>
    <p><strong>Total de Ejercicios Realizados:</strong> {{ $totalEjerciciosRealizados }} / {{ $totalEjerciciosEsperados }}</p>
    <p><strong>Progreso Global:</strong> {{ $progresoGlobal }}%</p>

    <h2>Planes Completados</h2>
    <table>
        <thead>
            <tr>
                <th>Plan</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Progreso</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($planes as $plan)
            <tr>
                <td>{{ $plan->tratamiento->set->descripcion }}</td>
                <td>{{ $plan->tratamiento->fecha_inicio->format('d/m/Y') }}</td>
                <td>{{ $plan->tratamiento->fecha_final->format('d/m/Y') }}</td>
                <td>{{ number_format(($plan->tratamiento->resultadosEjercicio->count() / $plan->tratamiento->set->ejercicios->count()) * 100, 2) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
