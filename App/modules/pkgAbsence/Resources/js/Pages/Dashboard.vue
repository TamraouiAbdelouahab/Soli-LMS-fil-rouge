<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-4 md:p-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Tableau de bord des Absences</h1>

            <!-- Filter Controls - Enhanced Style -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Segmented Control for Filter Type -->
                    <div class="flex flex-wrap gap-2 sm:gap-0 rounded-md shadow-sm bg-gray-100 p-1">
                        <button
                            v-for="typeOption in filterTypeOptions"
                            :key="typeOption.value"
                            @click="filter.type = typeOption.value; applyFilter()"
                            :class="[
                                'px-4 py-2 text-sm font-medium rounded-md transition-colors duration-200',
                                filter.type === typeOption.value
                                    ? 'bg-indigo-600 text-white shadow'
                                    : 'text-gray-700 hover:bg-gray-200'
                            ]"
                        >
                            {{ typeOption.label }}
                        </button>
                    </div>

                    <!-- Conditional Filter Value Inputs -->
                    <div class="flex-grow flex items-center gap-3 sm:justify-end w-full sm:w-auto">
                        <template v-if="filter.type === 'custom'">
                            <div class="flex flex-wrap gap-2 sm:gap-0 rounded-md shadow-sm bg-gray-100 p-1">
                                <button
                                    @click="filter.customSubType = 'custom_week'; applyFilter()"
                                    :class="[
                                        'px-3 py-1 text-xs font-medium rounded-md transition-colors duration-200',
                                        filter.customSubType === 'custom_week'
                                            ? 'bg-indigo-500 text-white shadow'
                                            : 'text-gray-600 hover:bg-gray-200'
                                    ]"
                                >
                                    Semaine
                                </button>
                                <button
                                    @click="filter.customSubType = 'custom_month'; applyFilter()"
                                    :class="[
                                        'px-3 py-1 text-xs font-medium rounded-md transition-colors duration-200',
                                        filter.customSubType === 'custom_month'
                                            ? 'bg-indigo-500 text-white shadow'
                                            : 'text-gray-600 hover:bg-gray-200'
                                    ]"
                                >
                                    Mois
                                </button>
                                <button
                                    @click="filter.customSubType = 'custom_year'; applyFilter()"
                                    :class="[
                                        'px-3 py-1 text-xs font-medium rounded-md transition-colors duration-200',
                                        filter.customSubType === 'custom_year'
                                            ? 'bg-indigo-500 text-white shadow'
                                            : 'text-gray-600 hover:bg-gray-200'
                                    ]"
                                >
                                    Année
                                </button>
                            </div>

                            <label v-if="filter.customSubType === 'custom_week'" for="customWeek" class="text-sm font-medium text-gray-700 whitespace-nowrap sr-only">Numéro de Semaine:</label>
                            <input v-if="filter.customSubType === 'custom_week'" type="number" id="customWeek" v-model="filter.value" @change="applyFilter" placeholder="N° Semaine"
                                   class="block w-full sm:w-32 px-3 py-2 text-base border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                            <label v-if="filter.customSubType === 'custom_month'" for="customMonth" class="text-sm font-medium text-gray-700 whitespace-nowrap sr-only">Mois:</label>
                            <select v-if="filter.customSubType === 'custom_month'" id="customMonth" v-model="filter.value" @change="applyFilter"
                                    class="block w-full sm:w-40 px-3 py-2 text-base border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>Sélectionner un mois</option>
                                <option v-for="m in 12" :key="m" :value="m">{{ new Date(2000, m - 1, 1).toLocaleString('fr-FR', { month: 'long' }) }}</option>
                            </select>

                            <label v-if="filter.customSubType === 'custom_year'" for="customYear" class="text-sm font-medium text-gray-700 whitespace-nowrap sr-only">Année:</label>
                            <input v-if="filter.customSubType === 'custom_year'" type="number" id="customYear" v-model="filter.value" @change="applyFilter" placeholder="Année (ex: 2023)"
                                   class="block w-full sm:w-32 px-3 py-2 text-base border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </template>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <SummaryCard 
                    :title="`Absences ${filterPeriodLabel}`"
                    :value="totalAbsencesToday ?? 0"
                    :trend="`Total des absences ${filterPeriodLabel}`" 
                    color="red" 
                    icon="UserX" 
                />
                <SummaryCard 
                    :title="`Apprenants absents ${filterPeriodLabel}`"
                    :value="learnersAbsentToday ?? 0"
                    :trend="`Apprenants concernés ${filterPeriodLabel}`" 
                    color="orange" 
                    icon="Users" 
                />
                <SummaryCard 
                    :title="`Taux d'absence global ${filterPeriodLabel}`"
                    :value="`${globalAbsenceRate ?? 0}%`"
                    :trend="`Pourcentage ${filterPeriodLabel}`" 
                    color="yellow" 
                    icon="TrendingUp" 
                />
                <SummaryCard 
                    :title="`Absences justifiées ${filterPeriodLabel}`"
                    :value="absenceStats ? `${absenceStats.justified}/${absenceStats.total}` : '0/0'"
                    :trend="`Justifiées / Total ${filterPeriodLabel}`" 
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
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Top 5 apprenants absents {{ filterPeriodLabel }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="apprenant in topMonthlyLearners" :key="apprenant.apprenant_id"
                         class="bg-gray-50 p-3 rounded-lg flex items-center justify-between border border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-sm">
                                {{ apprenant.nom.charAt(0) }}{{ apprenant.prenom.charAt(0) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ apprenant.nom }} {{ apprenant.prenom }}</p>
                                <p class="text-xs text-gray-500">{{ apprenant.tele_num }} </p>
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
    apprenants: Array,
    seances: Array,
    topMonthlyLearners: Array,
    currentFilter: Object,
});

// Filter options for the segmented control
const filterTypeOptions = [
    { label: 'Aujourd\'hui', value: 'today' },
    { label: 'Cette Semaine', value: 'week' },
    { label: 'Ce Mois', value: 'month' },
    { label: 'Cette Année', value: 'year' },
    { label: 'Personnalisé', value: 'custom' }, // A new 'custom' type to group custom filters
];

// Initialize filter state from props or default
const filter = ref({
    type: props.currentFilter?.type || 'month',
    value: props.currentFilter?.value || (props.currentFilter?.type === 'month' ? new Date().getMonth() + 1 : new Date().getFullYear()),
    // Add a sub-type for custom filters to manage which custom input is shown
    customSubType: props.currentFilter?.customSubType || 'custom_month' // Default custom to month
});

// Watch for changes in filter props and update local filter state
watch(() => props.currentFilter, (newFilter) => {
    if (newFilter) {
        filter.value.type = newFilter.type;
        filter.value.value = newFilter.value;
        filter.value.customSubType = newFilter.customSubType || 'custom_month'; // Ensure customSubType is set
    }
}, { deep: true, immediate: true });

// Watch for changes in filter type to reset filter value appropriately
watch(() => filter.value.type, (newType) => {
    const now = new Date();
    if (newType === 'custom') {
        // When switching to 'custom', default to 'custom_month' and set its value
        filter.value.customSubType = 'custom_month';
        filter.value.value = now.getMonth() + 1;
    } else {
        filter.value.customSubType = null; // Clear custom sub-type for non-custom filters
        switch (newType) {
            case 'today':
            case 'week':
            case 'year':
                filter.value.value = null; // No specific value needed for current day/week/year
                break;
            case 'month':
                filter.value.value = now.getMonth() + 1; // Current month
                break;
        }
    }
});

// Watch for changes in customSubType to reset filter value
watch(() => filter.value.customSubType, (newSubType) => {
    if (filter.value.type === 'custom') {
        filter.value.value = null; // Reset value when custom sub-type changes
        const now = new Date();
        if (newSubType === 'custom_month') {
            filter.value.value = now.getMonth() + 1;
        } else if (newSubType === 'custom_year') {
            filter.value.value = now.getFullYear();
        } else if (newSubType === 'custom_week') {
            // No default for custom week, user must input
        }
    }
});

// Computed property to generate the dynamic filter period label
const filterPeriodLabel = computed(() => {
    const type = filter.value.type;
    const value = filter.value.value;
    const customSubType = filter.value.customSubType;

    switch (type) {
        case 'today':
            return "aujourd'hui";
        case 'week':
            return "cette semaine";
        case 'month':
            return "ce mois";
        case 'year':
            return "cette année";
        case 'custom':
            switch (customSubType) {
                case 'custom_week':
                    return value ? `pour la semaine ${value}` : "pour une semaine spécifique";
                case 'custom_month':
                    if (value) {
                        const monthName = new Date(2000, value - 1, 1).toLocaleString('fr-FR', { month: 'long' });
                        return `pour le mois de ${monthName}`;
                    }
                    return "pour un mois spécifique";
                case 'custom_year':
                    return value ? `pour l'année ${value}` : "pour une année spécifique";
                default:
                    return "pour une période personnalisée";
            }
        default:
            return "ce mois"; // Default label
    }
});


const applyFilter = () => {
    let actualFilterType = filter.value.type;
    let actualFilterValue = filter.value.value;

    if (filter.value.type === 'custom') {
        actualFilterType = filter.value.customSubType;
        actualFilterValue = filter.value.value;
    }

    router.get(route('dashboard'), {
        filter_type: actualFilterType,
        filter_value: actualFilterValue,
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
