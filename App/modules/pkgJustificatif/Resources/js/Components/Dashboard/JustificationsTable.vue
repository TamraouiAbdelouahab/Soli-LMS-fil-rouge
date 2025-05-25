<template>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">justificatifs récentes</h2>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Apprenant</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Groupe</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Raison</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date depot</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(justification, index) in justifications" :key="index">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 mr-2">
                                    {{ justification.apprenant.nom.charAt(0) + justification.apprenant.prenom.charAt(0) }}
                                </div>
                                <div class="text-sm font-medium text-gray-900">{{ justification.apprenant.nom + " " + justification.apprenant.prenom }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{justification.apprenant.groupes.at(-1).nom}}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span
                                :class="`inline-flex px-2 py-1 text-xs rounded-full
                                    ${justification.statut === 'EN_ATTENTE' ? 'bg-yellow-300 text-yellow-800' :
                                     justification.statut === 'ACCEPTE' ?'bg-green-300 text-green-800' :
                                     'bg-red-300 text-red-800'
                                    }`">
                                {{  (justification.statut == "ACCEPTE") ? "accepté" :
                                    (justification.statut == "EN_ATTENTE") ? "en attente" :
                                    (justification.statut == "REJETE") ? "rejeté" :""}}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ justification.raison.title }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ justification.dateDepot }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800">
                                    <Edit class="h-4 w-4" />
                                </button>
                                <button class="text-red-600 hover:text-red-800">
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
         <div class="flex flex-col md:flex-row justify-end items-start md:items-center m-4">
            <div class="flex space-x-2 mt-2 md:mt-0">
                <button
                    class="bg-gray-100 hover:bg-gray-200 text-gray-900 px-3 py-1 rounded-md text-sm flex items-center">
                    Voir plus
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { FileText, FileSpreadsheet, Edit, Trash2 } from 'lucide-vue-next';

defineProps({
    justifications: {
        type: Array,
        required: true
    }
});
</script>
