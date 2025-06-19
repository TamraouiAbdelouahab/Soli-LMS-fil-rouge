<template>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID Apprenant
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nom
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nombre d'absences
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Statut
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="absentee in absentees" :key="absentee.apprenant_id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ absentee.apprenant_id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        Apprenant {{ absentee.apprenant_id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                              :class="getAbsencesBadgeClass(absentee.total)">
                            {{ absentee.total }} absences
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                              :class="getStatusBadgeClass(absentee.total)">
                            {{ getStatusText(absentee.total) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-indigo-600 hover:text-indigo-900 mr-3">
                            Voir détails
                        </button>
                        <button class="text-red-600 hover:text-red-900">
                            Contacter
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div v-if="!absentees || absentees.length === 0" class="text-center py-8">
            <p class="text-gray-500">Aucun apprenant fréquemment absent trouvé.</p>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    absentees: {
        type: Array,
        default: () => []
    }
});

const getAbsencesBadgeClass = (total) => {
    if (total >= 5) return 'bg-red-100 text-red-800';
    if (total >= 3) return 'bg-yellow-100 text-yellow-800';
    return 'bg-green-100 text-green-800';
};

const getStatusBadgeClass = (total) => {
    if (total >= 5) return 'bg-red-100 text-red-800';
    if (total >= 3) return 'bg-yellow-100 text-yellow-800';
    return 'bg-green-100 text-green-800';
};

const getStatusText = (total) => {
    if (total >= 5) return 'Critique';
    if (total >= 3) return 'Attention';
    return 'Normal';
};
</script>
