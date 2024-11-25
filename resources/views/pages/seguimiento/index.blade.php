<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-center">Seguimiento</h1>

        <!-- Resumen del Usuario -->
        <div class="mb-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Resumen General</h2>
            <p><strong>Nombre:</strong> {{ $user->name }}</p>
            <p><strong>Edad:</strong> {{ now()->year - $user->fecha_nacimiento->year }} años</p>
            @if($ultimoDiagnostico)
                <p><strong>Último Diagnóstico:</strong> {{ $ultimoDiagnostico->diagnostico }}</p>
                <p><strong>Zona Afectada:</strong> {{ $ultimoDiagnostico->zona_afectada }}</p>
            @endif
            <p><strong>Planes Completados:</strong> {{ $diagnosticos->count() }}</p>
            <p><strong>Ejercicios Realizados:</strong> {{ $totalEjerciciosRealizados }} / {{ $totalEjerciciosEsperados }}</p>
        </div>

        <!-- Progreso del Plan Actual -->
        @if($planActual)
            <div class="mb-8 bg-gray-100 p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Progreso del Plan Actual</h2>
                <p><strong>Plan Actual:</strong> {{ $planActual->set->descripcion }}</p>
                <p><strong>Progreso:</strong> {{ round($porcentajeProgreso, 2) }}%</p>
                <canvas id="progressChart"></canvas>
            </div>
        @endif

        <!-- Historial de Resultados -->
        <div class="mb-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Historial de Resultados</h2>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Ejercicio</th>
                        <th>Precisión</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resultados as $resultado)
                        <tr>
                            <td>{{ $resultado->fecha }}</td>
                            <td>{{ $resultado->ejercicio->nombre }}</td>
                            <td>{{ $resultado->porcentaje_precision }}%</td>
                            <td>{{ $resultado->observaciones }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Indicadores de Rendimiento -->
        <div class="mb-8 bg-gray-100 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Indicadores de Rendimiento (KPIs)</h2>
            <p><strong>Ejercicios de Alta Precisión (≥ 80%):</strong> {{ $resultadosAltos }}</p>
            <p><strong>Ejercicios por Mejorar (< 50%):</strong> {{ $resultadosBajos }}</p>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('progressChart').getContext('2d');
        const progressChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Esperados', 'Realizados'],
                datasets: [{
                    label: 'Ejercicios',
                    data: [{{ $totalEjerciciosEsperados }}, {{ $totalEjerciciosRealizados }}],
                    backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
