<template>
    <div class="chart-container">
        <canvas ref="chartRef"></canvas>
    </div>
</template>

<script>
import { defineComponent, ref, onMounted, watch, toRefs } from 'vue';
import Chart from 'chart.js/auto';

export default defineComponent({
    name: 'PieChart',
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
                type: 'pie',
                data: chartData.value,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 15,
                                padding: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: ${value}%`;
                                }
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