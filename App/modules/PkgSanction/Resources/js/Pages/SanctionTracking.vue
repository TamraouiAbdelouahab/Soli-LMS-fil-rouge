<!-- <template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-4 md:p-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Suivi des sanctions</h1>
                    <p class="text-lg text-gray-600">Gérez l'application et le suivi des sanctions</p>
                </div>

                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <button @click="exportSanctions"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <Download class="h-4 w-4 mr-2" />
                        Exporter
                    </button>

                    <button @click="refreshData"
                        class="inline-flex items-center px-4 py-2 bg-[#00B3C6] border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-[#0090a0] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#00B3C6]">
                        <RefreshCw class="h-4 w-4 mr-2" />
                    Actualiser
                    </button>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex">
                        <button @click="activeTab = 'pending'" :class="[
                            'py-4 px-6 text-sm font-medium border-b-2 transition-colors duration-200',
                            activeTab === 'pending'
                                ? 'border-blue-500 text-blue-600 bg-blue-50'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                        ]">
                            <div class="flex items-center">
                                <Clock class="h-4 w-4 mr-2" />
                                Sanctions à appliquer
                                <span
                                    class="ml-2 bg-orange-100 text-orange-800 text-xs font-medium px-2 py-1 rounded-full">
                                    {{ filteredPendingSanctions.length }}
                                </span>
                            </div>
                        </button>

                        <button @click="activeTab = 'applied'" :class="[
                            'py-4 px-6 text-sm font-medium border-b-2 transition-colors duration-200',
                            activeTab === 'applied'
                                ? 'border-blue-500 text-blue-600 bg-blue-50'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                        ]">
                            <div class="flex items-center">
                                <CheckCircle class="h-4 w-4 mr-2" />
                                Sanctions appliquées
                                <span
                                    class="ml-2 bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                    {{ filteredAppliedSanctions.length }}
                                </span>
                            </div>
                        </button>
                    </nav>
                </div>

                <div>
                    <div v-if="activeTab === 'pending'">
                        <div class="flex items-center justify-between px-6 py-4">
                            <h2 class="text-lg font-semibold text-gray-800">Sanctions en attente d'application</h2>
                            <div class="flex items-center space-x-2">
                                <select v-model="pendingStatusFilter"
                                    class="text-sm border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Tous les types</option>
                                    <option value="Avertissement">Avertissement</option>
                                    <option value="Blâme">Blâme</option>
                                    <option value="Exclusion">Exclusion</option>
                                </select>
                            </div>
                        </div>

                        <PendingSanctionsTable :sanctions="filteredPendingSanctions" @apply="applySanction"
                            @ignore="ignoreSanction" @view="viewSanction" />
                    </div>

                    <div v-if="activeTab === 'applied'">
                        <div class="flex items-center justify-between px-6 py-4">
                            <h2 class="text-lg font-semibold text-gray-800">Sanctions appliquées</h2>
                            <div class="flex items-center space-x-2">
                                <select v-model="appliedStatusFilter"
                                    class="text-sm border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Tous les statuts</option>
                                    <option value="Active">Active</option>
                                    <option value="Expired">Expirée</option>
                                    <option value="Lifted">Levée</option>
                                </select>
                            </div>
                        </div>

                        <AppliedSanctionsTable :sanctions="filteredAppliedSanctions" @view="viewSanction"
                            @lift="liftSanction" />
                    </div>
                </div>
            </div>

            <ViewSanctionModal v-if="showViewModal && selectedSanction" :sanction="selectedSanction"
                @close="showViewModal = false" />

            <ApplySanctionModal v-if="showApplyModal && selectedSanction" :sanction="selectedSanction"
                @close="showApplyModal = false" @confirm="confirmApplySanction" />
        </div>
    </AuthenticatedLayout>
</template> -->


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

            <!-- Stats Cards -->
            <!-- <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md border-l-4 border-golden-yellow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <Clock class="h-8 w-8 text-golden-yellow" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">À appliquer</p>
                            <p class="text-2xl font-bold text-charcoal-900">{{ pendingSanctions.length }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md border-l-4 border-teal-500 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <CheckCircle class="h-8 w-8 text-teal-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Appliquées</p>
                            <p class="text-2xl font-bold text-charcoal-900">{{ appliedSanctions.length }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md border-l-4 border-red-orange p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <AlertTriangle class="h-8 w-8 text-red-orange" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Actives</p>
                            <p class="text-2xl font-bold text-charcoal-900">{{ activeSanctionsCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md border-l-4 border-light-blue-400 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <Users class="h-8 w-8 text-light-blue-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Apprenants concernés</p>
                            <p class="text-2xl font-bold text-charcoal-900">{{ uniqueStudentsCount }}</p>
                        </div>
                    </div>
                </div>
            </div> -->

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
                                    {{ filteredPendingSanctions.length }}
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
                                    {{ filteredAppliedSanctions.length }}
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
                                    class="text-sm border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                    <option value="">Tous les types</option>
                                    <option value="Avertissement">Avertissement</option>
                                    <option value="Blâme">Blâme</option>
                                    <option value="Exclusion">Exclusion</option>
                                </select>
                            </div>
                        </div>

                        <PendingSanctionsTable :sanctions="filteredPendingSanctions" @apply="applySanction"
                            @ignore="ignoreSanction" @view="viewSanction" />
                    </div>

                    <!-- Applied Sanctions Tab -->
                    <div v-if="activeTab === 'applied'">
                        <div class="flex items-center justify-between px-6 py-4">
                            <h2 class="text-lg font-semibold text-charcoal-900">Sanctions appliquées</h2>
                            <div class="flex items-center space-x-2">
                                <select v-model="appliedStatusFilter"
                                    class="text-sm border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                    <option value="">Tous les statuts</option>
                                    <option value="Active">Active</option>
                                    <option value="Expired">Expirée</option>
                                    <option value="Lifted">Levée</option>
                                </select>
                            </div>
                        </div>

                        <AppliedSanctionsTable :sanctions="filteredAppliedSanctions" @view="viewSanction"
                            @lift="liftSanction" />
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
    Home,
    ChevronRight,
    Search,
    Download,
    RefreshCw,
    Clock,
    CheckCircle,
    AlertTriangle,
    Users
} from 'lucide-vue-next';

import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';
import PendingSanctionsTable from '../Components/Sanction/PendingSanctionsTable.vue';
import AppliedSanctionsTable from '../Components/Sanction/AppliedSanctionsTable.vue';
import ViewSanctionModal from '../Components/Sanction/ViewSanctionModal.vue';
import ApplySanctionModal from '../Components/Sanction/ApplySanctionModal.vue';

// Reactive data
const activeTab = ref('pending');
const searchQuery = ref('');
const classFilter = ref('');
const pendingStatusFilter = ref('');
const appliedStatusFilter = ref('');
const showViewModal = ref(false);
const showApplyModal = ref(false);
const selectedSanction = ref(null);

// Sample data for pending sanctions
const pendingSanctions = ref([
    {
        id: 1,
        learner: 'Jean Dupont',
        class: '1A',
        sanctionType: 'Avertissement',
        reason: 'Absences répétées (5/5)',
        calculatedOn: new Date('2024-01-25'),
        rule: 'Règle d\'absentéisme niveau 1',
        absenceCount: 5
    },
    {
        id: 2,
        learner: 'Marie Martin',
        class: '2B',
        sanctionType: 'Blâme',
        reason: 'Retards chroniques (8/8)',
        calculatedOn: new Date('2024-01-24'),
        rule: 'Règle retards répétés',
        absenceCount: 8
    },
    {
        id: 3,
        learner: 'Pierre Durand',
        class: '1B',
        sanctionType: 'Exclusion',
        reason: 'Absence examen important',
        calculatedOn: new Date('2024-01-23'),
        rule: 'Règle absence examens',
        absenceCount: 3
    },
    {
        id: 4,
        learner: 'Sophie Leroy',
        class: '2A',
        sanctionType: 'Avertissement',
        reason: 'Absences non justifiées (5/5)',
        calculatedOn: new Date('2024-01-22'),
        rule: 'Règle d\'absentéisme niveau 1',
        absenceCount: 5
    }
]);

// Sample data for applied sanctions
const appliedSanctions = ref([
    {
        id: 1,
        learner: 'Lucas Bernard',
        class: '1A',
        sanctionType: 'Avertissement',
        appliedOn: new Date('2024-01-20'),
        status: 'Active',
        duration: 7,
        appliedBy: 'M. Directeur',
        endDate: new Date('2024-01-27'),
        reason: 'Absences répétées'
    },
    {
        id: 2,
        learner: 'Emma Moreau',
        class: '2A',
        sanctionType: 'Blâme',
        appliedOn: new Date('2024-01-15'),
        status: 'Expired',
        duration: 14,
        appliedBy: 'Mme. Conseillère',
        endDate: new Date('2024-01-29'),
        reason: 'Comportement inapproprié'
    },
    {
        id: 3,
        learner: 'Hugo Petit',
        class: '1B',
        sanctionType: 'Exclusion',
        appliedOn: new Date('2024-01-10'),
        status: 'Lifted',
        duration: 21,
        appliedBy: 'M. Directeur',
        endDate: new Date('2024-01-31'),
        reason: 'Faute grave',
        liftedOn: new Date('2024-01-25'),
        liftedBy: 'M. Directeur'
    },
    {
        id: 4,
        learner: 'Camille Roux',
        class: '2B',
        sanctionType: 'Avertissement',
        appliedOn: new Date('2024-01-18'),
        status: 'Active',
        duration: 7,
        appliedBy: 'Mme. Conseillère',
        endDate: new Date('2024-01-25'),
        reason: 'Retards répétés'
    },
    {
        id: 5,
        learner: 'Thomas Blanc',
        class: '1A',
        sanctionType: 'Blâme',
        appliedOn: new Date('2024-01-12'),
        status: 'Active',
        duration: 14,
        appliedBy: 'M. Directeur',
        endDate: new Date('2024-01-26'),
        reason: 'Absences non justifiées'
    }
]);

// Computed properties
const filteredPendingSanctions = computed(() => {
    let filtered = pendingSanctions.value;

    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter(sanction =>
            sanction.learner.toLowerCase().includes(query)
        );
    }

    if (classFilter.value) {
        filtered = filtered.filter(sanction => sanction.class === classFilter.value);
    }

    if (pendingStatusFilter.value) {
        filtered = filtered.filter(sanction => sanction.sanctionType === pendingStatusFilter.value);
    }

    return filtered;
});

const filteredAppliedSanctions = computed(() => {
    let filtered = appliedSanctions.value;

    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter(sanction =>
            sanction.learner.toLowerCase().includes(query)
        );
    }

    if (classFilter.value) {
        filtered = filtered.filter(sanction => sanction.class === classFilter.value);
    }

    if (appliedStatusFilter.value) {
        filtered = filtered.filter(sanction => sanction.status === appliedStatusFilter.value);
    }

    return filtered;
});

const activeSanctionsCount = computed(() => {
    return appliedSanctions.value.filter(sanction => sanction.status === 'Active').length;
});

const uniqueStudentsCount = computed(() => {
    const allStudents = [
        ...pendingSanctions.value.map(s => s.learner),
        ...appliedSanctions.value.map(s => s.learner)
    ];
    return new Set(allStudents).size;
});

// Methods
const applySanction = (sanction) => {
    selectedSanction.value = sanction;
    showApplyModal.value = true;
};

const ignoreSanction = (sanction) => {
    if (confirm(`Êtes-vous sûr de vouloir ignorer la sanction pour ${sanction.learner}?`)) {
        const index = pendingSanctions.value.findIndex(s => s.id === sanction.id);
        if (index !== -1) {
            pendingSanctions.value.splice(index, 1);
        }
    }
};

const viewSanction = (sanction) => {
    selectedSanction.value = sanction;
    showViewModal.value = true;
};

const confirmApplySanction = (sanction, appliedBy) => {
    // Move from pending to applied
    const index = pendingSanctions.value.findIndex(s => s.id === sanction.id);
    if (index !== -1) {
        const appliedSanction = {
            id: Date.now(),
            learner: sanction.learner,
            class: sanction.class,
            sanctionType: sanction.sanctionType,
            appliedOn: new Date(),
            status: 'Active',
            duration: getDurationForSanctionType(sanction.sanctionType),
            appliedBy: appliedBy,
            endDate: new Date(Date.now() + getDurationForSanctionType(sanction.sanctionType) * 24 * 60 * 60 * 1000),
            reason: sanction.reason
        };

        appliedSanctions.value.unshift(appliedSanction);
        pendingSanctions.value.splice(index, 1);
    }

    showApplyModal.value = false;
    selectedSanction.value = null;
};

const liftSanction = (sanction) => {
    if (confirm(`Êtes-vous sûr de vouloir lever la sanction pour ${sanction.learner}?`)) {
        const index = appliedSanctions.value.findIndex(s => s.id === sanction.id);
        if (index !== -1) {
            appliedSanctions.value[index].status = 'Lifted';
            appliedSanctions.value[index].liftedOn = new Date();
            appliedSanctions.value[index].liftedBy = 'Utilisateur actuel';
        }
    }
};

const getDurationForSanctionType = (type) => {
    const durations = {
        'Avertissement': 7,
        'Blâme': 14,
        'Exclusion': 21
    };
    return durations[type] || 7;
};

const exportSanctions = () => {
    console.log('Exporting sanctions...');
    // Implementation for exporting sanctions
};

const refreshData = () => {
    console.log('Refreshing data...');
    // Implementation for refreshing data
};

onMounted(() => {
    console.log('Sanction tracking page mounted');
});
</script>

<style scoped>
/* Brand Colors */
.text-golden-yellow {
    color: #D99200;
}

.bg-golden-yellow {
    background-color: #D99200;
}

.border-golden-yellow {
    border-color: #D99200;
}

.text-teal-500 {
    color: #00B3C6;
}

.text-teal-600 {
    color: #00B3C6;
}

.text-teal-700 {
    color: #008A9B;
}

.bg-teal-500 {
    background-color: #00B3C6;
}

.bg-teal-600 {
    background-color: #00B3C6;
}

.bg-teal-700 {
    background-color: #008A9B;
}

.border-teal-500 {
    border-color: #00B3C6;
}

.ring-teal-500 {
    --tw-ring-color: #00B3C6;
}

.text-light-blue-600 {
    color: #9BB5D6;
}

.bg-light-blue-50 {
    background-color: #F5F7FB;
}

.border-light-blue-400 {
    border-color: #BCCCE5;
}

.text-charcoal-900 {
    color: #1E1E1E;
}

.text-red-orange {
    color: #FF5F33;
}

.border-red-orange {
    border-color: #FF5F33;
}

.text-bright-yellow {
    color: #FFDD33;
}

.bg-bright-yellow {
    background-color: #FFDD33;
}

/* Focus states */
.focus\:ring-teal-500:focus {
    --tw-ring-color: #00B3C6;
}

.focus\:border-teal-500:focus {
    border-color: #00B3C6;
}

/* Hover states */
.hover\:bg-teal-700:hover {
    background-color: #008A9B;
}

/* Tab transition animations */
.transition-colors {
    transition-property: color, background-color, border-color;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}

/* Custom scrollbar */
.overflow-x-auto::-webkit-scrollbar {
    height: 6px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #BCCCE5;
    border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #9BB5D6;
}
</style>