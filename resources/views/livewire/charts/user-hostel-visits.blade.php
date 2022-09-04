<div x-data="livewire_charts_user_hostel_visits">
    <div>
        <select class="rounded-lg border-none bg-gray-50 shadow-sm" wire:model="selectedDays">
            <option value="30">30 ngày</option>
            <option value="60">60 ngày</option>
            <option value="90">90 ngày</option>
        </select>

        <canvas x-ref="chart" class="h-full w-full"></canvas>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('livewire_charts_user_hostel_visits', () => ({
                labels: @entangle('labels'),
                data: @entangle('data'),
                chart: null,

                init() {
                    this.drawChart();

                    this.$watch('data', () => {
                        this.drawChart();
                    });
                },

                drawChart() {
                    this.chart?.destroy();
                    this.chart = new Chart(this.$refs.chart, {
                        type: 'line',
                        data: {
                            labels: this.labels,
                            datasets: [{
                                label: 'Số lượng lượt xem',
                                data: this.data,
                                borderColor: 'rgba(75, 134, 255, 1)',
                            }],
                        },

                    });
                },
            }));
        });
    </script>
</div>
