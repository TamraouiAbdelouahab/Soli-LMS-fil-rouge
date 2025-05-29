<!-- <template>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Apprenant
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Type de sanction
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Motif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Calculé le
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="sanction in sanctions" :key="sanction.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 mr-3">
                                {{ sanction.learner.charAt(0) }}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ sanction.learner }}</div>
                                <div class="text-sm text-gray-500">Classe {{ sanction.class }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span :class="[
                            'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                            getSanctionTypeColor(sanction.sanctionType)
                        ]">
                            {{ sanction.sanctionType }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ sanction.reason }}</div>
                        <div class="text-sm text-gray-500">{{ sanction.rule }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ formatDate(sanction.calculatedOn) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-2">
                            <button @click="$emit('apply', sanction)"
                                class="bg-green-100 hover:bg-green-200 text-green-800 px-3 py-1 rounded-md text-xs font-medium transition-colors">
                                <CheckCircle class="h-3 w-3 mr-1 inline" />
                                Appliquer
                            </button>
                            <button @click="$emit('ignore', sanction)"
                                class="bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1 rounded-md text-xs font-medium transition-colors">
                                <X class="h-3 w-3 mr-1 inline" />
                                Ignorer
                            </button>
                            <button @click="$emit('view', sanction)"
                                class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-md text-xs font-medium transition-colors">
                                <Eye class="h-3 w-3 mr-1 inline" />
                                Voir
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div v-if="sanctions.length === 0" class="text-center py-12">
            <Clock class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune sanction en attente</h3>
            <p class="mt-1 text-sm text-gray-500">Toutes les sanctions ont été traitées.</p>
        </div>
    </div>
</template>

<script setup>
import { CheckCircle, X, Eye, Clock } from 'lucide-vue-next';

defineProps({
    sanctions: {
        type: Array,
        required: true
    }
});

defineEmits(['apply', 'ignore', 'view']);

const getSanctionTypeColor = (type) => {
    const colors = {
        'Avertissement': 'bg-yellow-100 text-yellow-800',
        'Blâme': 'bg-orange-100 text-orange-800',
        'Exclusion': 'bg-red-100 text-red-800'
    };
    return colors[type] || 'bg-gray-100 text-gray-800';
};

const formatDate = (date) => {
    return new Intl.DateTimeFormat('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    }).format(date);
};
</script> -->

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-light-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Apprenant
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Type de sanction
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Motif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Calculé le
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="sanction in sanctions" :key="sanction.id" class="hover:bg-light-blue-25">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 rounded-full bg-light-blue-100 flex items-center justify-center text-teal-700 font-medium mr-3">
                                {{ sanction.learner.charAt(0) }}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-charcoal-900">{{ sanction.learner }}</div>
                                <div class="text-sm text-gray-500">Classe {{ sanction.class }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span :class="[
                            'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                            getSanctionTypeColor(sanction.sanctionType)
                        ]">
                            {{ sanction.sanctionType }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-charcoal-900">{{ sanction.reason }}</div>
                        <div class="text-sm text-gray-500">{{ sanction.rule }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ formatDate(sanction.calculatedOn) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-2">
                            <button @click="$emit('apply', sanction)"
                                class="bg-teal-100 hover:bg-teal-200 text-teal-800 px-3 py-1 rounded-md text-xs font-medium transition-colors">
                                <CheckCircle class="h-3 w-3 mr-1 inline" />
                                Appliquer
                            </button>
                            <button @click="$emit('ignore', sanction)"
                                class="bg-red-orange-100 hover:bg-red-orange-200 text-red-orange-800 px-3 py-1 rounded-md text-xs font-medium transition-colors">
                                <X class="h-3 w-3 mr-1 inline" />
                                Ignorer
                            </button>
                            <button @click="$emit('view', sanction)"
                                class="bg-light-blue-100 hover:bg-light-blue-200 text-light-blue-800 px-3 py-1 rounded-md text-xs font-medium transition-colors">
                                <Eye class="h-3 w-3 mr-1 inline" />
                                Voir
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Empty State -->
        <div v-if="sanctions.length === 0" class="text-center py-12">
            <Clock class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-medium text-charcoal-900">Aucune sanction en attente</h3>
            <p class="mt-1 text-sm text-gray-500">Toutes les sanctions ont été traitées.</p>
        </div>
    </div>
</template>

<script setup>
import { CheckCircle, X, Eye, Clock } from 'lucide-vue-next';

defineProps({
    sanctions: {
        type: Array,
        required: true
    }
});

defineEmits(['apply', 'ignore', 'view']);

const getSanctionTypeColor = (type) => {
    const colors = {
        'Avertissement': 'bg-bright-yellow text-charcoal-900',
        'Blâme': 'bg-golden-yellow text-white',
        'Exclusion': 'bg-red-orange text-white'
    };
    return colors[type] || 'bg-gray-100 text-gray-800';
};

const formatDate = (date) => {
    return new Intl.DateTimeFormat('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    }).format(date);
};
</script>

<style scoped>
/* Brand Colors */
.bg-light-blue-25 {
    background-color: #FAFBFC;
}

.bg-light-blue-50 {
    background-color: #F5F7FB;
}

.bg-light-blue-100 {
    background-color: #E8EDF5;
}

.bg-light-blue-200 {
    background-color: #D1DCE8;
}

.text-light-blue-800 {
    color: #5A7BA0;
}

.text-charcoal-900 {
    color: #1E1E1E;
}

.text-teal-700 {
    color: #008A9B;
}

.text-teal-800 {
    color: #006B7A;
}

.bg-teal-100 {
    background-color: #CCF2F5;
}

.bg-teal-200 {
    background-color: #99E5EA;
}

.bg-red-orange-100 {
    background-color: #FFE5DF;
}

.bg-red-orange-200 {
    background-color: #FFCBBF;
}

.text-red-orange-800 {
    color: #CC4C29;
}

.bg-bright-yellow {
    background-color: #FFDD33;
}

.bg-golden-yellow {
    background-color: #D99200;
}
</style>