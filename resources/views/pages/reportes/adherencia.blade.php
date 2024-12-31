<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Adherencia</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Reporte de Adherencia al Tratamiento</h1>
    <p><strong>Fecha del Reporte:</strong> {{ $fechaGeneracion }}</p>
    <p><strong>Usuario:</strong> {{ $user->name }}</p>
    <p><strong>Edad:</strong> {{ $edad }} años</p>

    <h2>Detalles por Tratamiento</h2>
    @foreach ($data as $item)
        <h3>Tratamiento: {{ $item['tratamiento']->set->descripcion }}</h3>
        <p><strong>Adherencia:</strong> {{ $item['adherencia'] }}%</p>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Ejercicios Realizados</th>
                    <th>Ejercicios Pendientes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item['ejerciciosPorDia'] as $dia)
                <tr>
                    <td>{{ $dia['fecha'] }}</td>
                    <td>{{ $dia['totalRealizados'] }}</td>
                    <td>{{ $dia['pendientes'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
