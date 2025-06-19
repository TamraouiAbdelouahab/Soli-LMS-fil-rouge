<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-4 md:p-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Tableau de bord des Absences</h1>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <SummaryCard 
                    title="Absences aujourd'hui"
                    :value="totalAbsencesToday ?? 0"
                    trend="Total des absences du jour" 
                    color="red" 
                    icon="UserX" 
                />
                <SummaryCard 
                    title="Apprenants absents"
                    :value="learnersAbsentToday ?? 0"
                    trend="Apprenants concernés aujourd'hui" 
                    color="orange" 
                    icon="Users" 
                />
                <SummaryCard 
                    title="Taux d'absence global"
                    :value="`${globalAbsenceRate ?? 0}%`"
                    trend="Pourcentage du jour" 
                    color="yellow" 
                    icon="TrendingUp" 
                />
                <SummaryCard 
                    title="Absences justifiées"
                    :value="absenceStats ? `${absenceStats.justified}/${absenceStats.total}` : '0/0'"
                    trend="Justifiées / Total" 
                    color="blue" 
                    icon="CheckCircle" 
                />
            </div>

            <!-- Additional Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Justifiées</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ absenceStats?.justified ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Non justifiées</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ absenceStats?.unjustified ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Sanctionnées</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ absenceStats?.sanctioned ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Évolution hebdomadaire des absences</h2>
                    <div class="h-64">
                        <LineChart :chartData="weeklyAbsencesChartData" />
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Top 5 des groupes avec absences</h2>
                    <div class="h-64">
                        <BarChart :chartData="topGroupsChartData" />
                    </div>
                </div>
            </div>

            <!-- Additional Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Séances avec le plus d'absents</h2>
                    <div class="h-64">
                        <PieChart :chartData="topSessionsChartData" />
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Évolution mensuelle</h2>
                    <div class="h-64">
                        <LineChart :chartData="monthlyAbsencesChartData" />
                    </div>
                </div>
            </div>

            <!-- Frequent Absentees Table -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Apprenants fréquemment absents</h2>
                <FrequentAbsenteesTable :absentees="frequentAbsentees" />
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';

import SummaryCard from './Components/SummaryCard.vue';
import FrequentAbsenteesTable from './Components/FrequentAbsenteesTable.vue';
import LineChart from './Components/LineChart.vue';
import PieChart from './Components/PieChart.vue';
import BarChart from './Components/BarChart.vue';

const props = defineProps({
    totalAbsencesToday: Number,
    learnersAbsentToday: Number,
    globalAbsenceRate: Number,
    topGroups: Array,
    topSessions: Array,
    weeklyRecap: Array,
    monthlyRecap: Array,
    frequentAbsentees: Array,
    absenceStats: Object,
});

// Calculer le total des absences de la semaine
const weeklyAbsencesCount = computed(() => {
    if (!props.weeklyRecap || !props.weeklyRecap.length) return 0;
    return props.weeklyRecap.reduce((sum, item) => sum + item.total, 0);
});

// Données pour le graphique hebdomadaire
const weeklyAbsencesChartData = computed(() => {
    if (!props.weeklyRecap || !props.weeklyRecap.length) {
        return {
            labels: [],
            datasets: []
        };
    }

    return {
        labels: props.weeklyRecap.map(item => {
            const date = new Date(item.day);
            return date.toLocaleDateString('fr-FR', { weekday: 'short', day: 'numeric' });
        }),
        datasets: [
            {
                label: 'Absences',
                data: props.weeklyRecap.map(item => item.total),
                borderColor: '#EF4444',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
            }
        ],
    };
});

// Données pour le graphique mensuel
const monthlyAbsencesChartData = computed(() => {
    if (!props.monthlyRecap || !props.monthlyRecap.length) {
        return {
            labels: [],
            datasets: []
        };
    }

    return {
        labels: props.monthlyRecap.map(item => `Semaine ${item.week}`),
        datasets: [
            {
                label: 'Absences',
                data: props.monthlyRecap.map(item => item.total),
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
            }
        ],
    };
});

// Données pour le graphique des groupes
const topGroupsChartData = computed(() => {
    if (!props.topGroups || !props.topGroups.length) {
        return {
            labels: [],
            datasets: []
        };
    }

    return {
        labels: props.topGroups.map(item => item.nom),
        datasets: [
            {
                label: 'Absences',
                data: props.topGroups.map(item => item.total),
                backgroundColor: [
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(139, 69, 19, 0.8)',
                ],
                borderWidth: 1,
            }
        ]
    };
});

// Données pour le graphique des séances
const topSessionsChartData = computed(() => {
    if (!props.topSessions || !props.topSessions.length) {
        return {
            labels: [],
            datasets: []
        };
    }

    return {
        labels: props.topSessions.map(item => item.nom),
        datasets: [
            {
                data: props.topSessions.map(item => item.total),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                ],
                borderWidth: 1,
            }
        ]
    };
});

</script>
