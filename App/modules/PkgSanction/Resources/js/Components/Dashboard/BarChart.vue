<template>
    <div class="chart-container">
        <canvas ref="chartRef"></canvas>
    </div>
</template>

<script>
import { defineComponent, ref, onMounted, watch, toRefs } from 'vue';
import Chart from 'chart.js/auto';

export default defineComponent({
    name: 'BarChart',
    props: {
        chartData: {
            type: Object,
            required: true
        }
    },
    setup(props) {
        const chartRef = ref(null);
        let chartInstance = null;
        const { chartData } = toRefs(props);

        const renderChart = () => {
            if (chartInstance) {
                chartInstance.destroy();
            }

            const ctx = chartRef.value.getContext('2d');
            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: chartData.value,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        };

        onMounted(() => {
            renderChart();
        });

        watch(chartData, () => {
            renderChart();
        }, { deep: true });

        return {
            chartRef
        };
    }
});
</script>

<style scoped>
.chart-container {
    position: relative;
    width: 100%;
    height: 100%;
}
</style>