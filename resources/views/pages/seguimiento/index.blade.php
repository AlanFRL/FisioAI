<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-center">Seguimiento</h1>

        <!-- Resumen del Usuario -->
        <div class="mb-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Resumen General</h2>
            <p><strong>Nombre:</strong> {{ $user->name }}</p>
            <p><strong>Edad:</strong> {{ now()->year - $user->fecha_nacimiento->year }} años</p>
            <p><strong>Planes Iniciados:</strong> {{ $diagnosticos->count() }}</p>
            <p><strong>Ejercicios Realizados (Global):</strong> {{ $totalEjerciciosRealizadosGlobal }} / {{ $totalEjerciciosEsperadosGlobal }}</p>
            <p><strong>Progreso Global:</strong> {{ number_format($porcentajeProgresoGlobal, 2) }}%</p>
        </div>

        <!-- Gráfico Global -->
        <div class="mb-8 bg-gray-100 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4 text-center">Gráfico Global de Progreso</h2>
            <canvas id="globalProgressChart" width="300" height="150"></canvas>
        </div>

        <div class="text-center mb-6">
            <a href="{{ route('reportes.progreso') }}" class="btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Descargar Reporte de Progreso General
            </a>
            <a href="{{ route('reportes.adherencia') }}" class="btn bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                Descargar Reporte de Adherencia al Tratamiento
            </a>
        </div>
        

        <!-- Detalles por Plan -->
        @foreach ($planes as $plan)
            <div class="mb-8 bg-gray-100 p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Plan: {{ $plan['tratamiento']->set->descripcion }}</h2>
                <p><strong>Nro de Tratamiento:</strong> {{ $plan['id'] }}</p>
                <p><strong>Progreso:</strong> {{ number_format($plan['porcentajeProgreso'], 2) }}%</p>
                <p><strong>Ejercicios Realizados:</strong> {{ $plan['totalEjerciciosRealizados'] }} / {{ $plan['totalEjerciciosEsperados'] }}</p>
                <p><strong>Ejercicios de Alta Precisión (≥ 80%):</strong> {{ $plan['resultadosAltos'] }}</p>
                <p><strong>Ejercicios por Mejorar (< 50%):</strong> {{ $plan['resultadosBajos'] }}</p>

                <!-- Gráfico del Plan -->
                <div class="mb-4">
                    <canvas id="planChart{{ $loop->index }}" width="300" height="150"></canvas>
                </div>

                <!-- Historial de Resultados -->
                <h3 class="text-lg font-semibold mt-4">Historial de Resultados</h3>
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
                        @foreach ($plan['resultados'] as $resultado)
                            <tr>
                                <td>{{ $resultado->fecha }}</td>
                                <td>{{ $resultado->ejercicio->nombre }}</td>
                                <td>{{ number_format($resultado->porcentaje_precision, 2) }}%</td>
                                <td>{{ $resultado->observaciones }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>

    <script>
        // Gráfico Global
        const globalProgressCtx = document.getElementById('globalProgressChart').getContext('2d');
        new Chart(globalProgressCtx, {
            type: 'doughnut',
            data: {
                labels: ['Ejercicios Realizados', 'Ejercicios Restantes'],
                datasets: [{
                    label: 'Progreso Global',
                    data: [{{ $totalEjerciciosRealizadosGlobal }}, {{ $totalEjerciciosEsperadosGlobal - $totalEjerciciosRealizadosGlobal }}],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Gráficos por Plan
        @foreach ($planes as $plan)
        const planChartCtx{{ $loop->index }} = document.getElementById('planChart{{ $loop->index }}').getContext('2d');
        new Chart(planChartCtx{{ $loop->index }}, {
            type: 'bar',
            data: {
                labels: ['Ejercicios Realizados', 'Ejercicios Restantes'],
                datasets: [{
                    label: 'Progreso del Plan',
                    data: [{{ $plan['totalEjerciciosRealizados'] }}, {{ $plan['totalEjerciciosEsperados'] - $plan['totalEjerciciosRealizados'] }}],
                    backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
        @endforeach
    </script>
</x-app-layout>
