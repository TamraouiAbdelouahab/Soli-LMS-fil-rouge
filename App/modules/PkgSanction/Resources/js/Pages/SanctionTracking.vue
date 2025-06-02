<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-4 md:p-6">

            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-charcoal-900 mb-2">Suivi des sanctions</h1>
                    <p class="text-lg text-gray-600">Gérez l'application et le suivi des sanctions</p>
                </div>

                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <button @click="exportSanctions"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-light-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        <Download class="h-4 w-4 mr-2" />
                        Exporter
                    </button>

                    <button @click="refreshData"
                        class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        <RefreshCw class="h-4 w-4 mr-2" />
                        Actualiser
                    </button>
                </div>
            </div>

            <!-- Tabs Section -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200 bg-light-blue-50">
                    <nav class="-mb-px flex">
                        <button @click="activeTab = 'pending'" :class="[
                            'py-4 px-6 text-sm font-medium border-b-2 transition-colors duration-200',
                            activeTab === 'pending'
                                ? 'border-teal-500 text-teal-700 bg-white'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                        ]">
                            <div class="flex items-center">
                                <Clock class="h-4 w-4 mr-2" />
                                Sanctions à appliquer
                                <span
                                    class="ml-2 bg-golden-yellow text-white text-xs font-medium px-2 py-1 rounded-full">
                                    {{ sanctionsCalculees.data.length }}
                                </span>
                            </div>
                        </button>

                        <button @click="activeTab = 'applied'" :class="[
                            'py-4 px-6 text-sm font-medium border-b-2 transition-colors duration-200',
                            activeTab === 'applied'
                                ? 'border-teal-500 text-teal-700 bg-white'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                        ]">
                            <div class="flex items-center">
                                <CheckCircle class="h-4 w-4 mr-2" />
                                Sanctions appliquées
                                <span class="ml-2 bg-teal-500 text-white text-xs font-medium px-2 py-1 rounded-full">
                                    {{ sanctionsApplied.data.length }}
                                </span>
                            </div>
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div>
                    <!-- Pending Sanctions Tab -->
                    <div v-if="activeTab === 'pending'">
                        <div class="flex items-center justify-between px-6 py-4">
                            <h2 class="text-lg font-semibold text-charcoal-900">Sanctions en attente d'application</h2>
                            <div class="flex items-center space-x-2">
                                <select v-model="pendingStatusFilter"
                                    class="text-sm border border-gray-300 rounded-md ps-3 pe-7 py-1 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                    <option value="">Tous les types</option>
                                    <option value="Avertissement">Avertissement</option>
                                    <option value="Blâme">Blâme</option>
                                    <option value="Exclusion">Exclusion</option>
                                </select>
                            </div>
                        </div>

                        <PendingSanctionsTable :sanctions="sanctionsCalculees.data" @apply="applySanction"
                            @ignore="ignoreSanction" @view="viewSanction" :links="sanctionsApplied.links" />
                    </div>

                    <!-- Applied Sanctions Tab -->
                    <div v-if="activeTab === 'applied'">
                        <div class="flex items-center justify-between px-6 py-4">
                            <h2 class="text-lg font-semibold text-charcoal-900">Sanctions appliquées</h2>
                            <div class="flex items-center space-x-2">
                                <select v-model="appliedStatusFilter"
                                    class="text-sm border border-gray-300 rounded-md ps-3 pe-7 py-1 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                    <option value="">Tous les statuts</option>
                                    <option value="Active">Active</option>
                                    <option value="Expired">Expirée</option>
                                    <option value="Lifted">Levée</option>
                                </select>
                            </div>
                        </div>

                        <AppliedSanctionsTable :sanctions="sanctionsApplied.data" :links="sanctionsApplied.links"
                            @view="viewSanction" @lift="liftSanction" />
                    </div>
                </div>
            </div>

            <!-- View Sanction Modal -->
            <ViewSanctionModal v-if="showViewModal && selectedSanction" :sanction="selectedSanction"
                @close="showViewModal = false" />

            <!-- Apply Sanction Modal -->
            <ApplySanctionModal v-if="showApplyModal && selectedSanction" :sanction="selectedSanction"
                @close="showApplyModal = false" @confirm="confirmApplySanction" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import {
    Download,
    RefreshCw,
    Clock,
    CheckCircle
} from 'lucide-vue-next';

import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';
import PendingSanctionsTable from '../Components/Sanction/PendingSanctionsTable.vue';
import AppliedSanctionsTable from '../Components/Sanction/AppliedSanctionsTable.vue';
import ViewSanctionModal from '../Components/Sanction/ViewSanctionModal.vue';
import ApplySanctionModal from '../Components/Sanction/ApplySanctionModal.vue';

const props = defineProps({
    sanctionsApplied: Object,
    sanctionsCalculees: Object,
})

console.log('Sanctions appliquées:', props.sanctionsCalculees);
// Reactive state
const activeTab = ref('pending');
const searchQuery = ref('');
const classFilter = ref('');
const pendingStatusFilter = ref('');
const appliedStatusFilter = ref('');
const showViewModal = ref(false);
const showApplyModal = ref(false);
const selectedSanction = ref(null);

// Sample pending sanctions data
// const pendingSanctions = ref([
//     {
//         id: 1,
//         learner: 'Jean Dupont',
//         class: '1A',
//         sanctionType: 'Avertissement',
//         reason: 'Absences répétées (5/5)',
//         calculatedOn: new Date('2024-01-25'),
//         rule: "Règle d'absentéisme niveau 1",
//         absenceCount: 5
//     },
//     {
//         id: 2,
//         learner: 'Marie Martin',
//         class: '2B',
//         sanctionType: 'Blâme',
//         reason: 'Retards chroniques (8/8)',
//         calculatedOn: new Date('2024-01-24'),
//         rule: 'Règle retards répétés',
//         absenceCount: 8
//     },
//     {
//         id: 3,
//         learner: 'Pierre Durand',
//         class: '1B',
//         sanctionType: 'Exclusion',
//         reason: 'Absence examen important',
//         calculatedOn: new Date('2024-01-23'),
//         rule: 'Règle absence examens',
//         absenceCount: 3
//     },
//     {
//         id: 4,
//         learner: 'Sophie Leroy',
//         class: '2A',
//         sanctionType: 'Avertissement',
//         reason: 'Absences non justifiées (5/5)',
//         calculatedOn: new Date('2024-01-22'),
//         rule: "Règle d'absentéisme niveau 1",
//         absenceCount: 5
//     }
// ]);

// const sanctionsApplied = ref({});

// Computed: Filtered Pending Sanctions based on selected filter and search query
const filteredPendingSanctions = computed(() => {
    return pendingSanctions.value.filter(sanction => {
        const matchesStatus = pendingStatusFilter.value ? sanction.sanctionType === pendingStatusFilter.value : true;
        // Extend with search or class filter if needed
        return matchesStatus;
    });
});

// Computed: Filtered Applied Sanctions based on selected filter and search query
// const filteredAppliedSanctions = computed(() => {
//     return appliedSanctions.value.filter(sanction => {
//         const matchesStatus = appliedStatusFilter.value ? sanction.status === appliedStatusFilter.value : true;
//         return matchesStatus;
//     });
// });

// Methods
function exportSanctions() {
    alert('Fonction d\'export des sanctions déclenchée.');
}

function refreshData() {
    alert('Données rafraîchies.');
}

function applySanction(sanction) {
    selectedSanction.value = sanction;
    showApplyModal.value = true;
}

function ignoreSanction(sanction) {
    alert(`Sanction ID ${sanction.id} ignorée.`);
}

function viewSanction(sanction) {
    selectedSanction.value = sanction;
    showViewModal.value = true;
}

function confirmApplySanction() {
    alert(`Sanction ID ${selectedSanction.value.id} appliquée.`);
    showApplyModal.value = false;
}

function liftSanction(sanction) {
    alert(`Sanction ID ${sanction.id} levée.`);
}


</script>

<style scoped>
.bg-light-blue-50 {
    background-color: #e0f2fe;
    /* Tailwind's light blue 50 */
}

.text-charcoal-900 {
    color: #2e2e2e;
    /* Custom charcoal color */
}

.bg-golden-yellow {
    background-color: #FFC107;
    /* Example golden yellow */
}
</style>
