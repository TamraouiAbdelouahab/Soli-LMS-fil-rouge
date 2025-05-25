<template>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Top 5 stagiaires</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(apprenant, index) in apprenants" :key="index">
                        <td class="px-4 py-3 whitespace-nowrap" style="width: 90%;">
                            <div class="flex items-center">
                                <div
                                    class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 mr-2">
                                    {{ apprenant.nom.charAt(0) + apprenant.prenom.charAt(0) }}
                                </div>
                                <div class="text-sm font-medium text-gray-900">{{ apprenant.nom + " " + apprenant.prenom }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ apprenant.justificatifs_count + " justificatif" }}{{ (apprenant.justificatifs_count != 1)?"s":"" }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { FileText, FileSpreadsheet, Edit, Trash2 } from 'lucide-vue-next';

defineProps({
    apprenants: {
        type: Array,
        required: true
    }
});
</script>
