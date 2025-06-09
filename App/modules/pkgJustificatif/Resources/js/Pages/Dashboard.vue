<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-4 md:p-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Tableau de bord --Justification d'absence</h1>
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <SummaryCard title="Total reçus" :value="justifications.length ?? 0" trend="+12% depuis le dernier trimestre"
                    color="blue" icon="Inbox" />
                <SummaryCard title="En attente" :value="justificationEnAttente" trend="-5% par rapport au mois dernier"
                    color="yellow" icon="Clock" />
                <SummaryCard title="Acceptés" :value="justificationAccepte" trend="+3 depuis la semaine dernière"
                    color="green" icon="Check" />
                <SummaryCard title="Taux de récurrence" value="15%" trend="-2% depuis le dernier trimestre"
                    color="teal" icon="Percent" />
            </div>
            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Justifications</h2>
                    <div class="h-56">
                        <PieChart :chartData="justificationTypesChartData" />
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow">
                        <TopStagiaire :apprenants="props.apprenants" />
                </div>
            </div>
            <JustificationsTable :justifications="justifications" class="mb-6" />
            <AnalyticsBox :justifications="justifications" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import SummaryCard from '../Components/Dashboard/SummaryCard.vue';
import JustificationsTable from '../Components/Dashboard/JustificationsTable.vue';
import AnalyticsBox from '../Components/Dashboard/AnalyticsBox.vue';
import PieChart from '../Components/Dashboard/PieChart.vue';
import TopStagiaire from '../Components/Dashboard/TopStagiaire.vue';


const props = defineProps({
    justifications:Object,
    apprenants:Object,
});

const justificationEnAttente = props.justifications.filter(justification => justification.status === 'EN_ATTENTE').length;
const justificationRejete = props.justifications.filter(justification => justification.status === 'REJETE').length;
const justificationAccepte = props.justifications.filter(justification => justification.status === 'ACCEPTE').length;

console.log(props.justifications);
console.log(props.apprenants);


const justificationTypesData = ref([
    { type: 'Acceptés', value: justificationAccepte },
    { type: 'Rejetés', value:  justificationRejete},
    { type: 'En attente', value: justificationEnAttente },
]);

const justificationTypesChartData = computed(() => {
    return {
        labels: justificationTypesData.value.map(item => item.type),
        datasets: [
            {
                data: justificationTypesData.value.map(item => item.value),
                backgroundColor:[
                    'rgba(34, 197, 94, 0.8)', // Blue
                    'rgba(255, 40, 40, 0.8)', // Red
                    'rgba(234, 179, 8, 0.8)', // Yellow
                    'rgba(75, 192, 192, 0.8)', // Teal
                    'rgba(153, 102, 255, 0.8)', // Purple
                        ],
                borderColor: [
                    'rgba(34, 197, 94, 1)',
                    'rgba(255, 40, 40, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 0.5
            }
        ]
    };
});
</script>
