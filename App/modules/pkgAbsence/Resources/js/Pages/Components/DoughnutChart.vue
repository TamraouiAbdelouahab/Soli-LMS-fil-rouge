<script setup>
import { Doughnut } from 'vue-chartjs'
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'

ChartJS.register(ArcElement, Tooltip, Legend)

const props = defineProps({
    data: {
        type: Array,
        required: true
    },
    labels: {
        type: Array,
        required: true
    },
    title: {
        type: String,
        default: ''
    },
    colors: {
        type: Array,
        default: () => ['#4CAF50', '#FFC107', '#F44336'] // green, amber, red
    }
})

const chartData = {
    labels: props.labels,
    datasets: [
        {
            backgroundColor: props.colors,
            data: props.data
        }
    ]
}

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom'
        },
        title: {
            display: !!props.title,
            text: props.title,
            font: {
                size: 16
            }
        }
    }
}
</script>

<template>
    <div class="chart-container">
        <Doughnut
            :data="chartData"
            :options="chartOptions"
        />
    </div>
</template>

<style scoped>
.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
}
</style> 