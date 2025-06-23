<template>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-700">Sanctions récentes</h2>
            <!-- <div class="flex space-x-2 mt-2 md:mt-0">
                <button
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-md text-sm flex items-center">
                    <FileText class="h-4 w-4 mr-1" />
                    Exporter PDF
                </button>
                <button
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-md text-sm flex items-center">
                    <FileSpreadsheet class="h-4 w-4 mr-1" />
                    Exporter CSV
                </button>
            </div> -->
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Apprenant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type
                            de sanction
                        </th>
                        <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Formateur</th> -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durée
                        </th>
                        <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Récurrence</th> -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(sanction, index) in sanctions" :key="index"
                        class="hover:bg-light-blue-25 border-gray-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="h-10 w-10 rounded-full bg-light-blue-100 flex items-center justify-center text-teal-700 font-medium mr-3">
                                    {{ sanction.absences[0]?.apprenant?.prenom?.charAt(0) || '?' }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ sanction.absences[0]?.apprenant?.nom || 'N/A' }}
                                        {{ sanction.absences[0]?.apprenant?.prenom || '' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Groupe {{ sanction.absences[0]?.apprenant?.groupes[0]?.nom || 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span :class="[
                                'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                                sanctionTypeColor(sanction.regle.sanction_type)
                            ]">
                                {{ sanction.regle.sanction_type }}
                            </span>
                        </td>
                        <!-- <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">{{ sanction.formateur }}</td> -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span :class="[
                                'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                                statusColor(sanction.status)
                            ]">
                                {{ statusLabel(sanction.status) }}
                            </span>
                            <div v-if="sanction.status === 'active'" class="text-xs text-gray-500 mt-1">
                                Fin: {{ formatDate(sanction.date_fin) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ sanction.duree }} jour{{ sanction.duree > 1 ? 's' : '' }}
                        </td>
                        <!-- <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">{{ sanction.recurrence }}</td> -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button @click="$emit('view', sanction)"
                                    class="bg-light-blue-100 hover:bg-light-blue-200 text-light-blue-800 px-3 py-1 rounded-md text-xs font-medium transition-colors">
                                    <Eye class="h-3 w-3 mr-1 inline" />
                                    Voir
                                </button>
                                <button @click="$emit('delete', sanction)"
                                    class="bg-red-orange-100 hover:bg-red-orange-200 text-red-orange-800 px-3 py-1 rounded-md text-xs font-medium transition-colors">
                                    <X class="h-3 w-3 mr-1 inline" />
                                    Supprimer
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
import { FileText, FileSpreadsheet, Edit, Trash2, Eye, X } from 'lucide-vue-next';

defineProps({
    sanctions: {
        type: Array,
        required: true
    },
    statusColor: {
        type: Function,
        required: true
    },
    statusLabel: {
        type: Function,
        required: true
    },
    formatDate: {
        type: Function,
        required: true
    },
    sanctionTypeColor: {
        type: Function,
        required: true
    }
});

const emit = defineEmits(['view', 'delete']);
</script>