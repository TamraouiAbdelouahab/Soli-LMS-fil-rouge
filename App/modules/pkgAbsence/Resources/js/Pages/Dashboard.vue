<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-4 md:p-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Tableau de bord des Absences</h1>

            <!-- Filter Controls -->
            <div class="bg-white rounded-lg shadow p-4 mb-6 flex flex-col sm:flex-row items-center gap-4">
                <div class="flex-grow">
                    <label for="filterType" class="block text-sm font-medium text-gray-700 sr-only">Filtrer par</label>
                    <select id="filterType" v-model="filter.type" @change="applyFilter"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="today">Aujourd'hui</option>
                        <option value="week">Cette Semaine</option>
                        <option value="month">Ce Mois</option>
                        <option value="year">Cette Année</option>
                        <option value="custom_week">Semaine Spécifique</option>
                        <option value="custom_month">Mois Spécifique</option>
                        <option value="custom_year">Année Spécifique</option>
                    </select>
                </div>

                <div v-if="filter.type === 'custom_week'" class="flex-grow">
                    <label for="customWeek" class="block text-sm font-medium text-gray-700 sr-only">Numéro de Semaine</label>
                    <input type="number" id="customWeek" v-model="filter.value" @change="applyFilter" placeholder="Numéro de semaine (1-52)"
                           class="mt-1 block w-full pl-3 pr-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                </div>

                <div v-if="filter.type === 'custom_month'" class="flex-grow">
                    <label for="customMonth" class="block text-sm font-medium text-gray-700 sr-only">Mois</label>
                    <select id="customMonth" v-model="filter.value" @change="applyFilter"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="" disabled>Sélectionner un mois</option>
                        <option v-for="m in 12" :key="m" :value="m">{{ new Date(2000, m - 1, 1).toLocaleString('fr-FR', { month: 'long' }) }}</option>
                    </select>
                </div>

                <div v-if="filter.type === 'custom_year'" class="flex-grow">
                    <label for="customYear" class="block text-sm font-medium text-gray-700 sr-only">Année</label>
                    <input type="number" id="customYear" v-model="filter.value" @change="applyFilter" placeholder="Année (ex: 2023)"
                           class="mt-1 block w-full pl-3 pr-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                </div>
            </div>

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
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Top 5 apprenants absents ce mois</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="apprenant in topMonthlyLearners" :key="apprenant.apprenant_id"
                         class="bg-gray-50 p-3 rounded-lg flex items-center justify-between border border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-sm">
                                {{ apprenant.nom.charAt(0) }}{{ apprenant.prenom.charAt(0) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ apprenant.nom }} {{ apprenant.prenom }}</p>
                                <p class="text-xs text-gray-500">{{ apprenant.prenom_arab }} {{ apprenant.nom_arab }}</p>
                            </div>
                        </div>
                        <span class="text-red-600 font-semibold text-sm">{{ apprenant.total }} absences</span>
                    </div>
                    <p v-if="!topMonthlyLearners || topMonthlyLearners.length === 0" class="text-gray-500 col-span-full text-center py-4">
                        Aucun apprenant absent ce mois-ci.
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';
import SummaryCard from './Components/SummaryCard.vue';
import LineChart from './Components/LineChart.vue';
import PieChart from './Components/PieChart.vue';
import BarChart from './Components/BarChart.vue';
// import { route } from '@inertiajs/vue3';

const props = defineProps({
    totalAbsencesToday: Number,
    learnersAbsentToday: Number,
    globalAbsenceRate: Number,
    topGroups: Array,
    topSessions: Array,
    weeklyRecap: Array,
    monthlyRecap: Array,
    frequentAbsentees: Array, // This prop is not used in the template, but kept for consistency
    absenceStats: Object,
    apprenants: Array,
    seances: Array,
    topMonthlyLearners: Array,
    currentFilter: Object, // New prop to receive current filter from backend
});

// Initialize filter state from props or default
const filter = ref({
    type: props.currentFilter?.type || 'month', // Default to 'month'
    value: props.currentFilter?.value || (props.currentFilter?.type === 'month' ? new Date().getMonth() + 1 : new Date().getFullYear()),
});

// Watch for changes in filter props and update local filter state
watch(() => props.currentFilter, (newFilter) => {
    if (newFilter) {
        filter.value.type = newFilter.type;
        filter.value.value = newFilter.value;
    }
}, { deep: true, immediate: true });


const applyFilter = () => {
    router.get(route('dashboard'), {
        filter_type: filter.value.type,
        filter_value: filter.value.value,
    }, {
        preserveState: true,
        preserveScroll: true,
        only: [
            'totalAbsencesToday', 'learnersAbsentToday', 'globalAbsenceRate',
            'absenceStats', 'weeklyRecap', 'monthlyRecap', 'topGroups',
            'topSessions', 'topMonthlyLearners', 'currentFilter'
        ],
    });
};

// Form for absence entry
const form = useForm({
    apprenant_id: '',
    seance_id: '',
    justifie: false,
});

const submitAbsence = () => {
    form.post(route('absences.store'), {
        onSuccess: () => {
            form.reset(); // Reset form fields on success
            // Reload relevant props, applying the current filter
            router.reload({
                only: [
                    'totalAbsencesToday', 'learnersAbsentToday', 'globalAbsenceRate',
                    'absenceStats', 'weeklyRecap', 'monthlyRecap', 'topGroups',
                    'topSessions', 'topMonthlyLearners'
                ],
                data: {
                    filter_type: filter.value.type,
                    filter_value: filter.value.value,
                }
            });
        },
        onError: (errors) => {
            console.error('Error submitting absence:', errors);
        }
    });
};

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

    const backgroundColors = [
        'rgba(239, 68, 68, 0.8)', // Red
        'rgba(245, 158, 11, 0.8)', // Orange
        'rgba(59, 130, 246, 0.8)', // Blue
        'rgba(16, 185, 129, 0.8)', // Green
        'rgba(139, 69, 19, 0.8)', // Brown
        'rgba(168, 85, 247, 0.8)', // Purple
        'rgba(255, 99, 132, 0.8)', // Pink
        'rgba(54, 162, 235, 0.8)', // Light Blue
        'rgba(255, 206, 86, 0.8)', // Yellow
        'rgba(75, 192, 192, 0.8)', // Teal
    ];

    return {
        labels: props.topGroups.map(item => item.nom),
        datasets: [
            {
                label: 'Absences',
                data: props.topGroups.map(item => item.total),
                backgroundColor: props.topGroups.map((_, index) => backgroundColors[index % backgroundColors.length]),
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

    const backgroundColors = [
        'rgba(59, 130, 246, 0.8)',
        'rgba(245, 158, 11, 0.8)',
        'rgba(239, 68, 68, 0.8)',
        'rgba(16, 185, 129, 0.8)',
        'rgba(168, 85, 247, 0.8)',
        'rgba(255, 99, 132, 0.8)',
        'rgba(54, 162, 235, 0.8)',
        'rgba(255, 206, 86, 0.8)',
        'rgba(75, 192, 192, 0.8)',
        'rgba(153, 102, 255, 0.8)',
    ];

    return {
        labels: props.topSessions.map(item => item.nom),
        datasets: [
            {
                data: props.topSessions.map(item => item.total),
                backgroundColor: props.topSessions.map((_, index) => backgroundColors[index % backgroundColors.length]),
                borderWidth: 1,
            }
        ]
    };
});
</script>
