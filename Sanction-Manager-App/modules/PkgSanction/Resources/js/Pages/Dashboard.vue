<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-4 md:p-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Tableau de bord</h1>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <SummaryCard title="Total des sanctions" :value="sanctionsAbsenceCount ?? 0" trend="+12% depuis le dernier trimestre"
                    color="blue" icon="Gavel" />
                <SummaryCard title="Sanctions ce mois-ci" value="32" trend="-5% par rapport au mois dernier"
                    color="orange" icon="Calendar" />
                <SummaryCard title="Sanctions non résolues" value="18" trend="+3 depuis la semaine dernière" color="red"
                    icon="AlertTriangle" />
                <SummaryCard title="Taux de récurrence" value="15%" trend="-2% depuis le dernier trimestre"
                    color="green" icon="Percent" />
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Évolution mensuelle des sanctions</h2>
                    <div class="h-64">
                        <LineChart :chartData="monthlyChartData" />
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Répartition par type de sanction</h2>
                    <div class="h-64">
                        <PieChart :chartData="sanctionTypesChartData" />
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Top 5 des formateurs ayant le plus d'apprenants
                    sanctionnés</h2>
                <div class="h-64">
                    <BarChart :chartData="trainersChartData" />
                </div>
            </div>

            <!-- Recent Sanctions Table -->
            <SanctionsTable :sanctions="recentSanctions" class="mb-6" />

            <!-- Analytics Box -->
            <AnalyticsBox :analytics="analyticsData" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';

import SummaryCard from '../Components/Dashboard/SummaryCard.vue';
import SanctionsTable from '../Components/Dashboard/SanctionsTable.vue';
import AnalyticsBox from '../Components/Dashboard/AnalyticsBox.vue';
import LineChart from '../Components/Dashboard/LineChart.vue';
import PieChart from '../Components/Dashboard/PieChart.vue';
import BarChart from '../Components/Dashboard/BarChart.vue';

const props = defineProps({
    sanctionsAbsenceCount: Number,
});

console.log(props.sanctionsAbsenceCount);
// Sample data for charts
const monthlyData = ref([
    { month: 'Jan', sanctions: 18 },
    { month: 'Fév', sanctions: 22 },
    { month: 'Mar', sanctions: 30 },
    { month: 'Avr', sanctions: 25 },
    { month: 'Mai', sanctions: 28 },
    { month: 'Juin', sanctions: 32 }
]);

const sanctionTypesData = ref([
    { type: 'Blâme', value: 45 },
    { type: 'Avertissement', value: 30 },
    { type: 'Exclusion', value: 15 },
    { type: 'Autre', value: 10 }
]);

const trainersData = ref([
    { name: 'Dupont', count: 15 },
    { name: 'Martin', count: 12 },
    { name: 'Dubois', count: 10 },
    { name: 'Bernard', count: 8 },
    { name: 'Thomas', count: 6 }
]);

// Prepare data for Chart.js
const monthlyChartData = computed(() => {
    return {
        labels: monthlyData.value.map(item => item.month),
        datasets: [
            {
                label: 'Sanctions',
                data: monthlyData.value.map(item => item.sanctions),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }
        ]
    };
});

const sanctionTypesChartData = computed(() => {
    return {
        labels: sanctionTypesData.value.map(item => item.type),
        datasets: [
            {
                data: sanctionTypesData.value.map(item => item.value),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(16, 185, 129, 0.8)'
                ],
                borderWidth: 1
            }
        ]
    };
});

const trainersChartData = computed(() => {
    return {
        labels: trainersData.value.map(item => item.name),
        datasets: [
            {
                label: 'Apprenants sanctionnés',
                data: trainersData.value.map(item => item.count),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(79, 70, 229, 0.8)',
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(168, 85, 247, 0.8)'
                ],
                borderWidth: 1
            }
        ]
    };
});

// Sample data for recent sanctions table
const recentSanctions = ref([
    {
        apprenant: 'Jean Dupont',
        type: 'Avertissement',
        formateur: 'Marie Martin',
        statut: 'En cours',
        date: '15/05/2023',
        recurrence: '1ère fois'
    },
    {
        apprenant: 'Sophie Moreau',
        type: 'Blâme',
        formateur: 'Thomas Dubois',
        statut: 'Résolue',
        date: '10/05/2023',
        recurrence: '2ème fois'
    },
    {
        apprenant: 'Lucas Bernard',
        type: 'Exclusion',
        formateur: 'Julie Petit',
        statut: 'Résolue',
        date: '05/05/2023',
        recurrence: '1ère fois'
    },
    {
        apprenant: 'Emma Leroy',
        type: 'Avertissement',
        formateur: 'Pierre Dupont',
        statut: 'En cours',
        date: '01/05/2023',
        recurrence: '1ère fois'
    },
    {
        apprenant: 'Hugo Roux',
        type: 'Blâme',
        formateur: 'Sophie Martin',
        statut: 'Résolue',
        date: '28/04/2023',
        recurrence: '3ème fois'
    }
]);

// Analytics data
const analyticsData = ref({
    tendance: {
        value: 'En hausse',
        icon: 'TrendingUp',
        color: 'red'
    },
    apprenants: {
        value: '12',
        icon: 'Users',
        color: 'orange'
    },
    duree: {
        value: '5 jours',
        icon: 'Clock',
        color: 'blue'
    },
    attente: {
        value: '7',
        icon: 'AlertCircle',
        color: 'red'
    }
});
</script>