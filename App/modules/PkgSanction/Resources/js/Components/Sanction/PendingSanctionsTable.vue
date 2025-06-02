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
                        Règle
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Calculé le
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <tr v-for="sanction in sanctions" :key="sanction.id"
                    class="hover:bg-light-blue-25 border-t border-gray-200 last:border-b">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 rounded-full bg-light-blue-100 flex items-center justify-center text-teal-700 font-medium mr-3">
                                {{ sanction.absences[0]?.apprenant?.prenom?.charAt(0) || '?' }}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-charcoal-900"> {{
                                    sanction.absences[0]?.apprenant?.nom || 'N/A' }}
                                    {{ sanction.absences[0]?.apprenant?.prenom || '' }}
                                </div>
                                <div class="text-sm text-gray-500">Groupe {{
                                    sanction.absences[0]?.apprenant?.groupes[0]?.nom || 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span :class="[
                            'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                            getSanctionTypeColor(sanction.regle.sanction_type)
                        ]">
                            {{ sanction.regle.sanction_type }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">{{ sanction.regle.titre }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ formatDate(sanction.created_at) }}
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

        <!-- Pagination -->
        <div v-if="links && links.length > 0" class="flex justify-end py-4 px-6">
            <nav class="inline-flex rounded-md shadow-sm">
                <button v-for="(link, index) in links" :key="index" v-html="link.label" :disabled="!link.url"
                    @click="changePage(link.url)" :class="[
                        'px-4 py-2 border text-sm',
                        link.active
                            ? 'bg-teal-600 text-white border-teal-600'
                            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100',
                        !link.url ? 'cursor-not-allowed opacity-50' : ''
                    ]"></button>
            </nav>
        </div>
    </div>
</template>

<script setup>
import { CheckCircle, X, Eye, Clock } from 'lucide-vue-next';

defineProps({
    sanctions: {
        type: Array,
        required: true,
        default: () => []
    },
    links: {
        type: Array,
        required: true,
        default: () => []
    }
});

defineEmits(['apply', 'ignore', 'view']);

const getSanctionTypeColor = (type) => {
    const colors = {
        'Avertissement': 'bg-bright-yellow-100 text-yellow-800',
        'Blâme': 'bg-golden-yellow-200 text-yellow-900',
        'Exclusion': 'bg-red-orange-100 text-red-orange-800'
    };
    return colors[type] || 'bg-gray-100 text-gray-800';
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
</script>

<style scoped></style>