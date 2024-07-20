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
                            @if ($scope === 'categories')
                            @if (auth()->user()->leader_id == 9 || auth()->user()->leader_id == 8 || auth()->user()->leader_id == 7)
                                    <div class="my-6">
                                        <h2 class="text-xl font-semibold capitalize">Categories Issues</h2>
                                        <div style="height: 400px;">
                                            <canvas id="chart-{{ $scope }}"></canvas>
                                        </div>
                                        @push('scripts')
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                const ctxCategories = document.getElementById('chart-{{ $scope }}').getContext('2d');
                                                const rawData = {!! json_encode($data) !!};
                                                const labels = Object.keys(rawData);
                                                const statusTypes = ['open', 'closed', 'inprogress', 'resolved'];

                                                const datasets = statusTypes.map(status => {
                                                    return {
                                                        label: status.charAt(0).toUpperCase() + status.slice(1),
                                                        data: labels.map(label => rawData[label][status] || 0),
                                                        backgroundColor: getBackgroundColor(status),
                                                        borderColor: getBorderColor(status),
                                                        borderWidth: 1
                                                    };
                                                });

                                                new Chart(ctxCategories, {
                                                    type: 'bar', // Using bar chart to handle multiple categories
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
                                                                        return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                                                                    }
                                                                }
                                                            }
                                                        },
                                                        scales: {
                                                            x: {
                                                                stacked: true,
                                                                title: {
                                                                    display: true,
                                                                    text: 'Category'
                                                                }
                                                            },
                                                            y: {
                                                                stacked: true,
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
                                @endif
                            @else
                                <div class="my-6">
                                    <h2 class="text-xl font-semibold capitalize">{{ str_replace('_', ' ', $scope) }} Issues</h2>
                                    <div style="height: 400px;">
                                        <canvas id="chart-{{ $scope }}"></canvas>
                                    </div>
                                    @push('scripts')
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const ctx{{ ucfirst($scope) }} = document.getElementById('chart-{{ $scope }}').getContext('2d');
                                            const rawData = {!! json_encode($data) !!};
                                            const labels = Object.keys(rawData);
                                            const statusTypes = ['open', 'closed', 'inprogress', 'resolved'];

                                            const datasets = statusTypes.map(status => {
                                                return {
                                                    label: status.charAt(0).toUpperCase() + status.slice(1),
                                                    data: labels.map(label => rawData[label][status] || 0),
                                                    backgroundColor: getBackgroundColor(status),
                                                    borderColor: getBorderColor(status),
                                                    borderWidth: 1
                                                };
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
                                                                    return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                                                                }
                                                            }
                                                        }
                                                    },
                                                    scales: {
                                                        x: {
                                                            stacked: true,
                                                            title: {
                                                                display: true,
                                                                text: '{{ str_replace('_', ' ', $scope) }}'
                                                            }
                                                        },
                                                        y: {
                                                            stacked: true,
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
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
