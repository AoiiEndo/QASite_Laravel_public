<div class="chart-container">
    <canvas id="testScoresChart"></canvas>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('testScoresChart').getContext('2d');
            const testScoresChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($testDates),
                    datasets: [{
                        label: '得点',
                        data: @json($testScores),
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: '実施日'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: '得点'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush