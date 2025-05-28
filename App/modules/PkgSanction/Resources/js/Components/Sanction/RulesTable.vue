<template>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Liste des Règles</h2>
                <div class="flex items-center space-x-2">
                    <select v-model="localStatusFilter"
                        class="text-sm border border-gray-300 rounded-md ps-3 pe-7 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous les statuts</option>
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Règle
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Paramètres</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dernière Modification</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="rule in computedRules" :key="rule.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ rule.titre }}</div>
                                <div class="text-sm text-gray-500 max-w-xs truncate">{{ rule.description }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 flex items-center space-x-4">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <Users class="h-3 w-3 mr-1" /> Max: {{ rule.absences_max }}
                                </span>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    <Bell class="h-3 w-3 mr-1" /> Seuil: {{ rule.seuil_de_notification }}
                                </span>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <Calendar class="h-3 w-3 mr-1" /> {{ rule.duree_sanction }}j
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span :class="[
                                'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                                rule.est_actif === 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                            ]">
                                {{ rule.est_actif === 1 ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ formatDate(rule.updated_at) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button @click="$emit('view', rule)" class="text-blue-600 hover:text-blue-900"
                                    title="Voir les détails">
                                    <Eye class="h-4 w-4" />
                                </button>
                                <button @click="$emit('edit', rule)" class="text-indigo-600 hover:text-indigo-900"
                                    title="Modifier">
                                    <Edit class="h-4 w-4" />
                                </button>
                                <button @click="$emit('toggle-status', rule)"
                                    :class="[rule.est_actif === 1 ? 'text-red-600' : 'text-green-600', 'hover:opacity-75']"
                                    :title="rule.est_actif === 1 ? 'Désactiver' : 'Activer'">
                                    <Power class="h-4 w-4" />
                                </button>
                                <button @click="$emit('delete', rule)" class="text-red-600 hover:text-red-900"
                                    title="Supprimer">
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Users, Bell, Calendar, Eye, Edit, Power, Trash2 } from 'lucide-vue-next'

const props = defineProps({
    rules: Array,
})

const localStatusFilter = ref('')

const computedRules = computed(() => {
    if (!localStatusFilter.value) return props.rules
    return props.rules.filter(r => r.est_actif === localStatusFilter.value)
})

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
