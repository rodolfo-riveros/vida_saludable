<div class="w-full py-8 px-4 sm:px-6 lg:px-8">
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <!-- Encabezado -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-8 text-blue-500">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                </svg>
                Panel de Estadísticas
            </h1>
            <div class="text-sm text-zinc-400 bg-zinc-800 px-3 py-1 rounded-lg">
                Actualizado: {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>

        <!-- Grid de Estadísticas - Diseño Mejorado -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Producto más vendido - Tarjeta con altura fija -->
            <div
                class="bg-zinc-800 border border-zinc-700 rounded-xl p-4 shadow-lg hover:bg-zinc-750 transition-all duration-300 flex flex-col h-full">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h2 class="text-md font-semibold text-zinc-300">Producto Más Vendido</h2>
                        <p class="text-xs text-zinc-500">Este mes</p>
                    </div>
                    <div class="p-2 bg-green-900/50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                        </svg>
                    </div>
                </div>

                <div class="mt-auto">
                    @if ($mostSoldProduct)
                        <p class="text-xl font-bold text-green-500 truncate mb-1"
                            title="{{ $mostSoldProduct['name'] }}">{{ $mostSoldProduct['name'] }}</p>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-zinc-400 truncate">Categoría: {{ $mostSoldProduct['category'] }}</span>
                            <span
                                class="font-medium text-white bg-green-900/30 px-2 py-1 rounded whitespace-nowrap">{{ $mostSoldProduct['quantity'] }}
                                unid.</span>
                        </div>
                    @else
                        <p class="text-zinc-400 text-sm py-2">No hay datos</p>
                    @endif
                </div>
            </div>

            <!-- Producto menos vendido - Mismo diseño que el más vendido -->
            <div
                class="bg-zinc-800 border border-zinc-700 rounded-xl p-4 shadow-lg hover:bg-zinc-750 transition-all duration-300 flex flex-col h-full">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h2 class="text-md font-semibold text-zinc-300">Producto Menos Vendido</h2>
                        <p class="text-xs text-zinc-500">Este mes</p>
                    </div>
                    <div class="p-2 bg-red-900/50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-red-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181" />
                        </svg>
                    </div>
                </div>

                <div class="mt-auto">
                    @if ($leastSoldProduct)
                        <p class="text-xl font-bold text-red-500 truncate mb-1" title="{{ $leastSoldProduct['name'] }}">
                            {{ $leastSoldProduct['name'] }}</p>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-zinc-400 truncate">Categoría: {{ $leastSoldProduct['category'] }}</span>
                            <span
                                class="font-medium text-white bg-red-900/30 px-2 py-1 rounded whitespace-nowrap">{{ $leastSoldProduct['quantity'] }}
                                unid.</span>
                        </div>
                    @else
                        <p class="text-zinc-400 text-sm py-2">No hay datos</p>
                    @endif
                </div>
            </div>

            <!-- Total de clientes - Tarjeta con mismo alto -->
            <div
                class="bg-zinc-800 border border-zinc-700 rounded-xl p-4 shadow-lg hover:bg-zinc-750 transition-all duration-300 flex flex-col h-full">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h2 class="text-md font-semibold text-zinc-300">Total de Clientes</h2>
                        <p class="text-xs text-zinc-500">Registrados</p>
                    </div>
                    <div class="p-2 bg-blue-900/50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                </div>

                <div class="mt-auto">
                    <p class="text-xl font-bold text-blue-500 mb-1">{{ $totalCustomers }}</p>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-zinc-400">Clientes activos</span>
                        <span class="font-medium text-white bg-blue-900/30 px-2 py-1 rounded whitespace-nowrap">
                            +{{ $newCustomersThisMonth }} este mes
                            @if ($customerGrowthPercentage >= 0)
                                (<span class="text-green-400">↑{{ $customerGrowthPercentage }}%</span>)
                            @else
                                (<span class="text-red-400">↓{{ abs($customerGrowthPercentage) }}%</span>)
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Ventas totales - Tarjeta con mismo alto -->
            <div
                class="bg-zinc-800 border border-zinc-700 rounded-xl p-4 shadow-lg hover:bg-zinc-750 transition-all duration-300 flex flex-col h-full">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h2 class="text-md font-semibold text-zinc-300">Ventas Totales</h2>
                        <p class="text-xs text-zinc-500">Este mes</p>
                    </div>
                    <div class="p-2 bg-purple-900/50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-purple-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="mt-auto">
                    <p class="text-xl font-bold text-purple-500 mb-1">S/ {{ $formattedTotalSales }}</p>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-zinc-400">Ingresos</span>
                        <span class="font-medium text-white bg-purple-900/30 px-2 py-1 rounded whitespace-nowrap">
                            @if ($salesGrowthPercentage >= 0)
                                <span class="text-green-400">↑{{ abs($salesGrowthPercentage) }}%</span>
                            @else
                                <span class="text-red-400">↓{{ abs($salesGrowthPercentage) }}%</span>
                            @endif
                            vs anterior
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección inferior - Gráfico y últimas ventas -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Gráfico de ventas -->
            <div class="bg-zinc-800 border border-zinc-700 rounded-xl p-4 shadow-lg lg:col-span-2">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
                    <h2 class="text-md font-semibold text-zinc-300 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        Tendencia de Ventas
                    </h2>
                </div>
                <div
                    class="bg-zinc-900/50 rounded-lg h-64 flex items-center justify-center text-zinc-500 border border-zinc-700">
                    {{-- Canvas for the sales chart --}}
                    <canvas id="salesChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Últimas ventas -->
            <div class="bg-zinc-800 border border-zinc-700 rounded-xl p-4 shadow-lg">
                <h2 class="text-md font-semibold text-zinc-300 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 text-green-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    Últimas Ventas
                </h2>
                <div class="space-y-3">
                    @forelse($latestSales as $sale)
                        <div
                            class="flex justify-between items-center py-2 px-2 bg-zinc-900/20 rounded-lg hover:bg-zinc-900/40 transition-colors">
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="p-1.5 bg-blue-900/20 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-400">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-white truncate">{{ $sale['customer_name'] }}
                                    </p>
                                    <p class="text-xs text-zinc-400 truncate">{{ $sale['tipo_comprobante'] }}
                                        #{{ $sale['id'] }} • {{ $sale['time_ago'] }}</p>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-green-500 whitespace-nowrap ml-2">S/
                                {{ number_format($sale['total'], 2) }}</span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-zinc-400 text-sm">
                            No hay ventas recientes
                        </div>
                    @endforelse
                </div>
                <a href="{{ route('admin.venta_detalle.index') }}"
                    class="mt-3 inline-flex items-center text-xs text-blue-500 hover:text-blue-400">
                    Ver todas las ventas
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-3 h-3 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

@script
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Directly pass the initial sales data from Livewire PHP component
        const initialSalesData = @js($lastThreeMonthsSales);

        function renderSalesChart(salesData) {
            console.log('Sales Data for Chart:', salesData); // Debugging line

            const labels = salesData.map(item => item.month);
            const totals = salesData.map(item => item.total);

            const ctx = document.getElementById('salesChart').getContext('2d');

            // Destroy existing chart instance if it exists to prevent issues on subsequent renders
            if (window.salesChartInstance) {
                window.salesChartInstance.destroy();
            }

            window.salesChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ganancias (en miles)',
                        data: totals,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.6)', // Color for the first bar
                            'rgba(153, 102, 255, 0.6)', // Color for the second bar
                            'rgba(255, 159, 64, 0.6)' // Color for the third bar
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Allows chart to fill the container
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Ganancias (en miles)',
                                color: '#a1a1aa' // text-zinc-400
                            },
                            ticks: {
                                color: '#a1a1aa' // text-zinc-400
                            },
                            grid: {
                                color: '#3f3f46' // zinc-700
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Mes',
                                color: '#a1a1aa' // text-zinc-400
                            },
                            ticks: {
                                color: '#a1a1aa' // text-zinc-400
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#a1a1aa' // text-zinc-400
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Ganancias: $' + context.parsed.y + 'K';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Render the chart initially with the data passed from PHP
        document.addEventListener('livewire:initialized', () => {
            renderSalesChart(initialSalesData);
        });

        // Listen for updates from Livewire if the data changes later
        Livewire.on('salesDataUpdated', (data) => {
            renderSalesChart(data.lastThreeMonthsSales);
        });
    </script>
@endscript
