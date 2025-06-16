<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-4 md:p-6">

            <!-- Main Content -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-charcoal-900 mb-2">Mes sanctions</h1>
                    <p class="text-lg text-gray-600">Historique et suivi de vos sanctions</p>
                </div>

                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <div
                        class="flex items-center space-x-2 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center">
                            <span class="text-sm text-gray-600">Total</span>
                        </div>
                        <div class="h-4 border-r border-gray-300"></div>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-600">{{ sanctions ? sanctions.length : 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sanctions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <SanctionCard v-for="sanction in sanctions" :key="sanction.id" :sanction="sanction"
                    @view="viewSanctionDetails" :formatDate="formatDate" :getDurationText="getDurationText"
                    :getRemainingDays="getRemainingDays" :getHeaderColorClass="getHeaderColorClass"
                    :getIconBgClass="getIconBgClass" :getSanctionIcon="getSanctionIcon" />
            </div>

            <!-- Empty State -->
            <div v-if="sanctions.length === 0" class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400">
                    <FileX class="h-full w-full" />
                </div>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Aucune sanction</h3>
                <p class="mt-1 text-gray-500">Vous n'avez aucune sanction à afficher.</p>
            </div>

            <!-- View Details Modal -->
            <SanctionDetailsModal v-if="showDetailsModal && selectedSanction" :sanction="selectedSanction"
                @close="showDetailsModal = false" :formatDate="formatDate" :getDurationText="getDurationText"
                :getRemainingDays="getRemainingDays" :getHeaderColorClass="getHeaderColorClass"
                :getIconBgClass="getIconBgClass" :getSanctionIcon="getSanctionIcon" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import {
    FileX,
    AlertTriangle,
    Ban,
    Clock3
} from 'lucide-vue-next';
import SanctionCard from '../Components/LearnerSanctions/SanctionCard.vue';
import SanctionDetailsModal from '../Components/LearnerSanctions/SanctionDetailsModal .vue';
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    sanctions: {
        type: Array,
        default: () => []
    }
});

console.log('Sanctions:', props.sanctions);

const showDetailsModal = ref(false);
const selectedSanction = ref(null);

// Method to view sanction details
const viewSanctionDetails = (sanction) => {
    selectedSanction.value = sanction;
    showDetailsModal.value = true;
};

const formatDate = (date) => {
    const parsedDate = new Date(date);
    if (isNaN(parsedDate)) return 'Date invalide';
    return new Intl.DateTimeFormat('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    }).format(parsedDate);
};

const getDurationText = (date_debut, date_fin) => {
    const start = new Date(date_debut);
    const end = new Date(date_fin);
    const diffTime = Math.abs(end - start);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    return `Durée: ${diffDays} jour${diffDays > 1 ? 's' : ''}`;
};

const getRemainingDays = (date_fin) => {
    const today = new Date();
    const end = new Date(date_fin);
    const diffTime = Math.abs(end - today);
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
};

// Get header color class based on sanction type
const getHeaderColorClass = (type) => {
    const colors = {
        'Mise en garde': 'bg-yellow-500',
        'Avertissement': 'bg-yellow-500',
        'Blâme': 'bg-orange-500',
        'Exclusion': 'bg-red-500',
        'Suspension': 'bg-teal-600'
    };
    return colors[type] || 'bg-gray-600';
};

// Get icon background class based on sanction type
const getIconBgClass = (type) => {
    const colors = {
        'Mise en garde': 'bg-yellow-600',
        'Avertissement': 'bg-yellow-600',
        'Blâme': 'bg-orange-600',
        'Exclusion': 'bg-red-600',
        'Suspension': 'bg-teal-700'
    };
    return colors[type] || 'bg-gray-700';
};

//
const getSanctionIcon = (type) => {
    const icons = {
        'Mise en garde': AlertTriangle,
        'Avertissement': AlertTriangle,
        'Blâme': Ban,
        'Exclusion': Ban,
        'Suspension': Clock3
    };
    return icons[type] || AlertTriangle;
};

</script>
