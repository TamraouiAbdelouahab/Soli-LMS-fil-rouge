<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tableau de bord des sanctions
            </h2>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-8">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                    <ClipboardIcon class="h-6 w-6 text-white" />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Sanctions totales</dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">42</div>
                                            <span class="ml-2 text-sm font-medium text-green-600">+8%</span>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                    <AlertTriangleIcon class="h-6 w-6 text-white" />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Nombre d'avertissements
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">28</div>
                                            <span class="ml-2 text-sm font-medium text-yellow-600">+12%</span>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                    <BanIcon class="h-6 w-6 text-white" />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Nombre de suspensions
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">14</div>
                                            <span class="ml-2 text-sm font-medium text-red-600">+5%</span>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Graph Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Line Chart -->
                    <div class="bg-white shadow rounded-lg p-4">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Évolution des sanctions</h2>
                        <div class="h-80">
                            <SanctionsLineChart :chartData="lineChartData" />
                        </div>
                    </div>

                    <!-- Bar Chart -->
                    <div class="bg-white shadow rounded-lg p-4">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Distribution des sanctions</h2>
                        <div class="h-80">
                            <SanctionsBarChart :chartData="barChartData" />
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white shadow rounded-lg mb-8 p-4">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Filtres</h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label for="formateur" class="block text-sm font-medium text-gray-700">Formateur</label>
                            <select id="formateur" v-model="filters.formateur"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="">Tous les formateurs</option>
                                <option value="Jean Dupont">Jean Dupont</option>
                                <option value="Marie Martin">Marie Martin</option>
                                <option value="Pierre Durand">Pierre Durand</option>
                            </select>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">État</label>
                            <select id="status" v-model="filters.status"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="">Tous les états</option>
                                <option value="En cours">En cours</option>
                                <option value="Levée">Levée</option>
                                <option value="En attente">En attente</option>
                            </select>
                        </div>
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type de sanction</label>
                            <select id="type" v-model="filters.type"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="">Tous les types</option>
                                <option value="Avertissement">Avertissement</option>
                                <option value="Suspension temporaire">Suspension temporaire</option>
                                <option value="Suspension définitive">Suspension définitive</option>
                            </select>
                        </div>
                        <div>
                            <label for="periode" class="block text-sm font-medium text-gray-700">Période</label>
                            <select id="periode" v-model="filters.periode"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="7">7 derniers jours</option>
                                <option value="30">30 derniers jours</option>
                                <option value="90">3 derniers mois</option>
                                <option value="180">6 derniers mois</option>
                                <option value="365">Année en cours</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button @click="resetFilters"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-3">
                            <RefreshCwIcon class="h-4 w-4 mr-1" />
                            Réinitialiser
                        </button>
                        <button @click="applyFilters"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <FilterIcon class="h-4 w-4 mr-1" />
                            Appliquer
                        </button>
                    </div>
                </div>

                <!-- Sanctions Table -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div
                        class="px-4 py-5 sm:px-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h2 class="text-lg font-medium text-gray-900">Sanctions récentes</h2>
                        <div class="relative w-full sm:w-auto">
                            <input type="text" v-model="searchQuery" placeholder="Rechercher un apprenant..."
                                class="w-full sm:w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <SearchIcon class="h-5 w-5 text-gray-400" />
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Apprenant
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type de sanction
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        État
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Formateur
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="(sanction, index) in filteredSanctions" :key="index">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                {{ sanction.apprenant.charAt(0) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ sanction.apprenant }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ sanction.email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ sanction.date }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ sanction.type }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            :class="`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusClass(sanction.etat)}`">
                                            {{ sanction.etat }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ sanction.formateur }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button
                                                class="text-blue-600 hover:text-blue-900 p-1 rounded-md hover:bg-blue-50">
                                                <EyeIcon class="h-4 w-4" />
                                            </button>
                                            <button
                                                class="text-blue-600 hover:text-blue-900 p-1 rounded-md hover:bg-blue-50">
                                                <EditIcon class="h-4 w-4" />
                                            </button>
                                            <button
                                                class="text-red-600 hover:text-red-900 p-1 rounded-md hover:bg-red-50">
                                                <TrashIcon class="h-4 w-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <button
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Précédent
                            </button>
                            <button
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Suivant
                            </button>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Affichage de <span class="font-medium">1</span> à <span
                                        class="font-medium">10</span> sur
                                    <span class="font-medium">42</span> résultats
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                    aria-label="Pagination">
                                    <button
                                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Précédent</span>
                                        <ChevronLeftIcon class="h-5 w-5" />
                                    </button>
                                    <button
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        1
                                    </button>
                                    <button
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600 hover:bg-gray-50">
                                        2
                                    </button>
                                    <button
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        3
                                    </button>
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                        ...
                                    </span>
                                    <button
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        8
                                    </button>
                                    <button
                                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Suivant</span>
                                        <ChevronRightIcon class="h-5 w-5" />
                                    </button>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';
import SanctionsLineChart from '../Components/SanctionsLineChart.vue';
import SanctionsBarChart from '../Components/SanctionsBarChart.vue';
import {
    ClipboardIcon,
    AlertTriangleIcon,
    BanIcon,
    SearchIcon,
    EyeIcon,
    EditIcon,
    TrashIcon,
    ChevronLeftIcon,
    ChevronRightIcon,
    RefreshCwIcon,
    FilterIcon
} from 'lucide-vue-next';

const searchQuery = ref('');

const filters = ref({
    formateur: '',
    status: '',
    type: '',
    periode: '30'
});

const sanctions = ref([
    {
        apprenant: 'Thomas Dubois',
        email: 'thomas.dubois@example.com',
        date: '15/04/2023',
        type: 'Avertissement',
        etat: 'En cours',
        formateur: 'Marie Martin'
    },
    {
        apprenant: 'Sophie Leroy',
        email: 'sophie.leroy@example.com',
        date: '10/04/2023',
        type: 'Suspension temporaire',
        etat: 'En cours',
        formateur: 'Jean Dupont'
    },
    {
        apprenant: 'Lucas Moreau',
        email: 'lucas.moreau@example.com',
        date: '05/04/2023',
        type: 'Avertissement',
        etat: 'Levée',
        formateur: 'Pierre Durand'
    },
    {
        apprenant: 'Emma Bernard',
        email: 'emma.bernard@example.com',
        date: '01/04/2023',
        type: 'Suspension définitive',
        etat: 'En attente',
        formateur: 'Marie Martin'
    },
    {
        apprenant: 'Hugo Petit',
        email: 'hugo.petit@example.com',
        date: '28/03/2023',
        type: 'Avertissement',
        etat: 'Levée',
        formateur: 'Jean Dupont'
    },
    {
        apprenant: 'Chloé Roux',
        email: 'chloe.roux@example.com',
        date: '25/03/2023',
        type: 'Suspension temporaire',
        etat: 'Levée',
        formateur: 'Pierre Durand'
    },
    {
        apprenant: 'Nathan Fournier',
        email: 'nathan.fournier@example.com',
        date: '20/03/2023',
        type: 'Avertissement',
        etat: 'En cours',
        formateur: 'Marie Martin'
    }
]);

// Données pour le graphique en ligne
const lineChartData = {
    labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin'],
    datasets: [
        {
            label: 'Sanctions totales',
            data: [12, 19, 25, 32, 38, 42],
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            borderWidth: 2,
            tension: 0.3,
            fill: true
        },
        {
            label: 'Sanctions en cours',
            data: [8, 12, 15, 18, 20, 18],
            borderColor: 'rgb(245, 158, 11)',
            backgroundColor: 'rgba(245, 158, 11, 0.1)',
            borderWidth: 2,
            tension: 0.3,
            fill: true
        },
        {
            label: 'Sanctions levées',
            data: [4, 7, 10, 14, 18, 24],
            borderColor: 'rgb(34, 197, 94)',
            backgroundColor: 'rgba(34, 197, 94, 0.1)',
            borderWidth: 2,
            tension: 0.3,
            fill: true
        }
    ]
};

// Données pour le graphique en barres
const barChartData = {
    labels: ['Avertissements', 'Suspensions temporaires', 'Suspensions définitives'],
    datasets: [
        {
            label: 'Nombre de sanctions',
            data: [28, 10, 4],
            backgroundColor: [
                'rgba(245, 158, 11, 0.7)',
                'rgba(59, 130, 246, 0.7)',
                'rgba(239, 68, 68, 0.7)'
            ],
            borderColor: [
                'rgb(245, 158, 11)',
                'rgb(59, 130, 246)',
                'rgb(239, 68, 68)'
            ],
            borderWidth: 1
        }
    ]
};

const filteredSanctions = computed(() => {
    return sanctions.value.filter(sanction => {
        if (searchQuery.value && !sanction.apprenant.toLowerCase().includes(searchQuery.value.toLowerCase())) {
            return false;
        }

        if (filters.value.formateur && sanction.formateur !== filters.value.formateur) {
            return false;
        }

        if (filters.value.status && sanction.etat !== filters.value.status) {
            return false;
        }

        if (filters.value.type && sanction.type !== filters.value.type) {
            return false;
        }

        return true;
    });
});

const getStatusClass = (status) => {
    switch (status) {
        case 'En cours':
            return 'bg-yellow-100 text-yellow-800';
        case 'Levée':
            return 'bg-green-100 text-green-800';
        case 'En attente':
            return 'bg-gray-100 text-gray-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};

const resetFilters = () => {
    filters.value = {
        formateur: '',
        status: '',
        type: '',
        periode: '30'
    };
    searchQuery.value = '';
};

const applyFilters = () => {
    // Cette fonction serait utilisée pour appliquer les filtres
    // et potentiellement faire une requête API
    console.log('Filtres appliqués:', filters.value);
};
</script>