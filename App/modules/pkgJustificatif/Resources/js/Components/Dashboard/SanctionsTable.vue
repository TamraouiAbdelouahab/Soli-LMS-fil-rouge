<template>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Sanctions récentes</h2>
            <div class="flex space-x-2 mt-2 md:mt-0">
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
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Apprenant</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Formateur</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Récurrence</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(sanction, index) in sanctions" :key="index">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 mr-2">
                                    {{ sanction.apprenant.charAt(0) }}
                                </div>
                                <div class="text-sm font-medium text-gray-900">{{ sanction.apprenant }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ sanction.type }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ sanction.formateur }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span
                                :class="`inline-flex px-2 py-1 text-xs rounded-full ${sanction.statut === 'Résolue' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800'}`">
                                {{ sanction.statut }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ sanction.date }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ sanction.recurrence }}</td>
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
    </div>
</template>

<script setup>
import { FileText, FileSpreadsheet, Edit, Trash2 } from 'lucide-vue-next';

defineProps({
    sanctions: {
        type: Array,
        required: true
    }
});
</script>