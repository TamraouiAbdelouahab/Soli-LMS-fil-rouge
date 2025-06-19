<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-4 md:p-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Tableau de bord - sanctions</h1>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <SummaryCard title="Sanctions actives"
                    :value="recentSanctionsCount ? `${activeSanctionCount}/${sanctionsAbsenceCount}` : '0/0'"
                    trend="Voir les détails" color="teal" icon="Gavel" clickable @view-details="goToSanctions" />
                <SummaryCard title="Sanctions  semaine" :value="recentSanctionsCount ?? 0"
                    trend="Voir les détails" color="orange" icon="Calendar" clickable @view-details="goToSanctions"/>
                <SummaryCard title="Sanctions non résolues" :value="sanctionsAbsenceCalculeeCount ?? 0"
                    trend="Voir les détails" color="red" icon="AlertTriangle" clickable @view-details="goToSanctions" />
                <SummaryCard title="Apprenants Concerné" :value="learnersSanctionedCount ?? 0" trend="Voir les détails"
                    color="blue" icon="Users" clickable @view-details="goToSanctions" />
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Évolution mensuelle des sanctions</h2>
                    <div class="h-64">
                        <LineChart :chartData="monthlySanctionsChartData" />
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Répartition par type de sanction</h2>
                    <div class="h-64">
                        <PieChart :chartData="sanctionsByTypesChartData" />
                    </div>
                </div>
            </div>

            <!-- Recent Sanctions Table -->
            <SanctionsTable :sanctions="recentSanctions" :statusColor="getStatusColor" :statusLabel="getStatusLabel"
                @view="viewSanction" @page-change="changePage" @delete="deleteSanction" :formatDate="formatDate"
                :sanctionTypeColor="getSanctionTypeColor" class="mb-6" />

            <ViewSanctionModal v-if="showViewModal && selectedSanction" :sanction="selectedSanction"
                :sanctionTypeColor="getSanctionTypeColor" :statusColor="getStatusColor" :statusLabel="getStatusLabel"
                @close="showViewModal = false" :formatDate="formatDate" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';

import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';
import SummaryCard from '../Components/Dashboard/SummaryCard.vue';
import SanctionsTable from '../Components/Dashboard/SanctionsTable.vue';
import LineChart from '../Components/Dashboard/LineChart.vue';
import PieChart from '../Components/Dashboard/PieChart.vue';
import ViewSanctionModal from '../Components/Sanction/ViewSanctionModal.vue';

const props = defineProps({
    sanctionsAbsenceCount: Number,
    sanctionsAbsenceCalculeeCount: Number,
    recentSanctions: Array,
    recentSanctionsCount: Number,
    activeSanctionCount: Number,
    monthlySanctions: Array,
    sanctionsByTypes: Array,
    learnersSanctionedCount: Number,
});

// console.log(props.learnersSanctionedCount);

const showViewModal = ref(false);
const selectedSanction = ref(null);

const monthlySanctionsChartData = computed(() => {
    if (!props.monthlySanctions || !props.monthlySanctions.length) {
        return {
            labels: [],
            datasets: []
        };
    }

    return {
        labels: props.monthlySanctions.map(item => item.month),
        datasets: [
            {
                label: 'Sanctions',
                data: props.monthlySanctions.map(item => item.count),
                borderColor: '#00B3C6',
                backgroundColor: '#F0FAFB',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
            }
        ],
    };
});

const sanctionsByTypesChartData = computed(() => {
    return {
        labels: props.sanctionsByTypes.map(item => item.sanction_type),
        datasets: [
            {
                data: props.sanctionsByTypes.map(item => item.value),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                ],
                borderWidth: 1,
            }
        ]
    };
});

function deleteSanction(sanction) {
    router.delete(route('sanction.tracking.destroyAppliedSanction', sanction.id));
}

function viewSanction(sanction) {
    selectedSanction.value = sanction;
    showViewModal.value = true;
}

const statusStyles = {
    active: {
        label: 'Active',
        color: 'bg-teal-100 text-teal-800'
    },
    expirée: {
        label: 'Expirée',
        color: 'bg-gray-100 text-gray-800'
    },
    lifted: {
        label: 'Levée',
        color: 'bg-light-blue-100 text-light-blue-800'
    }
};

const getStatusColor = (status) => statusStyles[status]?.color || 'bg-gray-100 text-gray-800';

const getStatusLabel = (status) => statusStyles[status]?.label || status;

const formatDate = (date) => {
    const parsedDate = new Date(date);
    if (isNaN(parsedDate)) return 'Date invalide';
    return new Intl.DateTimeFormat('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    }).format(parsedDate);
};

const getSanctionTypeColor = (type) => {
    const colors = {
        'Avertissement': 'bg-bright-yellow-100 text-yellow-800',
        'Blâme': 'bg-golden-yellow-200 text-yellow-900',
        'Exclusion': 'bg-red-orange-100 text-red-orange-800'
    };
    return colors[type] || 'bg-gray-100 text-gray-800';
};

function goToSanctions() {
    router.get(route('sanction.tracking.index'));
}
</script>