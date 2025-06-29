<template>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-charcoal-900">Liste des Règles</h2>
                <div class="flex items-center space-x-2">
                    <select v-model="localStatusFilter"
                        class="text-sm border border-gray-300 rounded-md ps-3 pe-7 py-1 focus:outline-none focus:ring-2 focus:ring-teal-500">
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
                <thead class="bg-light-blue-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Règle
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Paramètres
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dernière Modification
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="rule in computedRules" :key="rule.id" class="hover:bg-light-blue-25">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-charcoal-900">{{ rule.titre }}</div>
                                <div class="text-sm text-gray-500 max-w-xs truncate">
                                    {{ rule.description && rule.description.length > 24 ? rule.description.slice(0, 24)
                                        + '...' :
                                        rule.description }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-charcoal-900 flex items-center space-x-4">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-50 text-teal-800 space-x-1">
                                    <Users class="h-3 w-3" /> <span>Max: {{ rule.absences_max }}</span>
                                </span>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-50 text-teal-800 space-x-1">
                                    <Bell class="h-3 w-3" /> <span>Seuil: {{ rule.seuil_de_notification }}</span>
                                </span>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-50 text-teal-800 space-x-1">
                                    <Calendar class="h-3 w-3" /> <span>{{ rule.duree_sanction }}j</span>
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span :class="[
                                'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                                rule.est_actif === 1
                                    ? 'bg-teal-100 text-teal-800'
                                    : 'bg-red-orange-100 text-red-orange-800'
                            ]">
                                {{ rule.est_actif === 1 ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ formatDate(rule.updated_at) }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex flex-col gap-2">

                                <!-- Row 1 -->
                                <div class="flex gap-2">
                                    <button @click="$emit('view', rule)"
                                        class="bg-light-blue-100 hover:bg-light-blue-200 text-light-blue-800 px-3 py-1 rounded-md text-xs font-medium transition flex items-center w-full justify-center">
                                        <Eye class="h-3 w-3 mr-1" />
                                        Voir
                                    </button>

                                    <button @click="$emit('delete', rule)"
                                        class="bg-red-orange-100 hover:bg-red-orange-200 text-red-orange-800 px-3 py-1 rounded-md text-xs font-medium transition flex items-center w-full justify-center">
                                        <Trash2 class="h-3 w-3 mr-1" />
                                        Supprimer
                                    </button>
                                </div>

                                <!-- Row 2 -->
                                <div class="flex gap-2">
                                    <button @click="$emit('edit', rule)"
                                        class="bg-teal-100 hover:bg-teal-200 text-teal-800 px-3 py-1 rounded-md text-xs font-medium transition flex items-center w-full justify-center">
                                        <Edit class="h-3 w-3 mr-1" />
                                        Modifier
                                    </button>

                                    <button @click="$emit('toggle-status', rule)" :class="[
                                        'px-3 py-1 rounded-md text-xs font-medium flex items-center w-full justify-center transition',
                                        rule.est_actif === 1
                                            ? 'bg-red-orange-100 hover:bg-red-orange-200 text-red-orange-800'
                                            : 'bg-teal-100 hover:bg-teal-200 text-teal-800'
                                    ]">
                                        <Power class="h-3 w-3 mr-1" />
                                        {{ rule.est_actif === 1 ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </div>

                            </div>
                        </td>


                    </tr>
                </tbody>
            </table>

            <!-- Empty State -->
            <div v-if="rules.length === 0" class="text-center py-12">
                <FileText class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune règle définie</h3>
                <p class="mt-1 text-sm text-gray-500">Les règles de sanction apparaîtront ici.</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Users, Bell, Calendar, Eye, Edit, Power, Trash2, FileText } from 'lucide-vue-next';

const props = defineProps({
    rules: {
        type: Array,
        required: true
    },
    formatDate: {
        type: Function,
        required: true
    },
});

const localStatusFilter = ref('');

const computedRules = computed(() => {
    if (!localStatusFilter.value) return props.rules;
    return props.rules.filter((r) =>
        localStatusFilter.value === 'active' ? r.est_actif === 1 : r.est_actif === 0
    );
});

</script>
