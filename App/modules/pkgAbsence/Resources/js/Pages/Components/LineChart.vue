<template>
    <canvas ref="chartCanvas"></canvas>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const props = defineProps({
    chartData: Object,
});

const chartCanvas = ref(null);
let myChart = null;

const renderChart = () => {
    if (myChart) {
        myChart.destroy();
    }
    myChart = new Chart(chartCanvas.value, {
        type: 'line',
        data: props.chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e5e7eb',
                    },
                },
            },
        },
    });
};

onMounted(() => {
    renderChart();
});

watch(() => props.chartData, () => {
    renderChart();
}, { deep: true });
</script>
