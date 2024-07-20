<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-3xl font-bold">Issue Insights</h1>
                    </div>
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                        @foreach ($filteredData as $scope => $data)
                            <div class="my-6">
                                <h2 class="text-xl font-semibold capitalize">{{ $scope }} Issues</h2>
                                <div style="height: 400px;">
                                    <canvas id="chart-{{ $scope }}"></canvas>
                                </div>
                                @push('scripts')
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const ctx{{ ucfirst($scope) }} = document.getElementById('chart-{{ $scope }}').getContext('2d');
                                        const labels = {!! json_encode(array_keys($data)) !!};
                                        const rawData = {!! json_encode($data) !!};
                                        const datasets = [];
                                        const statusTypes = ['open', 'closed', 'inprogress', 'resolved'];

                                        statusTypes.forEach(status => {
                                            const dataset = {
                                                label: status.charAt(0).toUpperCase() + status.slice(1),
                                                data: labels.map(label => {
                                                    return rawData[label] && rawData[label][status] ? rawData[label][status] : 0;
                                                }),
                                                backgroundColor: getBackgroundColor(status),
                                                borderColor: getBorderColor(status),
                                                borderWidth: 1
                                            };
                                            datasets.push(dataset);
                                        });

                                        new Chart(ctx{{ ucfirst($scope) }}, {
                                            type: 'bar',
                                            data: {
                                                labels: labels,
                                                datasets: datasets
                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: false,
                                                plugins: {
                                                    tooltip: {
                                                        callbacks: {
                                                            label: function(tooltipItem) {
                                                                const label = tooltipItem.dataset.label;
                                                                const value = tooltipItem.raw;
                                                                return `${label}: ${value}`;
                                                            }
                                                        }
                                                    }
                                                },
                                                scales: {
                                                    x: {
                                                        title: {
                                                            display: true,
                                                            text: 'Location'
                                                        }
                                                    },
                                                    y: {
                                                        title: {
                                                            display: true,
                                                            text: 'Count'
                                                        },
                                                        beginAtZero: true
                                                    }
                                                }
                                            }
                                        });

                                        function getBackgroundColor(status) {
                                            switch (status) {
                                                case 'open': return 'rgba(54, 162, 235, 0.8)';
                                                case 'closed': return 'rgba(255, 99, 132, 0.8)';
                                                case 'inprogress': return 'rgba(75, 192, 192, 0.8)';
                                                case 'resolved': return 'rgba(153, 102, 255, 0.8)';
                                                default: return 'rgba(255, 159, 64, 0.8)';
                                            }
                                        }

                                        function getBorderColor(status) {
                                            switch (status) {
                                                case 'open': return 'rgba(54, 162, 235, 1)';
                                                case 'closed': return 'rgba(255, 99, 132, 1)';
                                                case 'inprogress': return 'rgba(75, 192, 192, 1)';
                                                case 'resolved': return 'rgba(153, 102, 255, 1)';
                                                default: return 'rgba(255, 159, 64, 1)';
                                            }
                                        }
                                    });
                                </script>
                                @endpush
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
