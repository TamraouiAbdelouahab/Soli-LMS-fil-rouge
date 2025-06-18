<template>
    <ConfirmDelete @closeConfirmation = "deleteConfirmationVisible = false"
                    v-show="deleteConfirmationVisible"
                    @confirm="confirmDeleteJustification"
                    @cancel = "deleteConfirmationVisible = false"
                    />
    <div class="min-h-[calc(65vh)] max-h-[calc(70vh)]">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Les Justifications</h2>
            </div>
            <div class="overflow-x-auto" >
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
                        <tr v-for="(justification, index) in justifications.data" :key="index">
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
                                        ${justification.status === 'EN_ATTENTE' ? 'bg-yellow-300 text-yellow-800' :
                                        justification.status === 'ACCEPTE' ?'bg-green-300 text-green-800' :
                                        'bg-red-300 text-red-800'
                                        }`">
                                    {{  (justification.status == "ACCEPTE") ? "accepté" :
                                        (justification.status == "EN_ATTENTE") ? "en attente" :
                                        (justification.status == "REJETE") ? "rejeté" :""}}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ justification.raison.libelle }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ justification.dateDepot }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-800">
                                        <Edit class="h-4 w-4"
                                            @click="emit('openUpdateModal',justification.id)"
                                        />
                                    </button>
                                    <button class="text-red-600 hover:text-red-800" @click="deleteJustification(justification.id)">
                                        <Trash2 class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <Pagination :Links="props.justifications.links"  v-show="props.justifications.links.length > 3" />

</template>

<script setup>
import { FileText, FileSpreadsheet, Edit, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';
import Pagination from './pagination.vue';
import { router } from '@inertiajs/vue3'
import ConfirmDelete from "./deleteConfirm.vue"
const props = defineProps({
    justifications: {
        type: Object,
        required: true
    }
});
const deleteConfirmationVisible = ref(false)
const idToDelete = ref(null);
const emit = defineEmits(['openDeleteConfirmation','closeDeleteConfirmation','openUpdateModal']);

const deleteJustification = (id) => {
    idToDelete.value = id;
    deleteConfirmationVisible.value = true;
};
const confirmDeleteJustification = () => {
    router.delete(idToDelete.value)
    deleteConfirmationVisible.value = false;
    setTimeout(() => {
        emit('openDeleteConfirmation');
    }, 1000);
    setTimeout(() => {
        emit('closeDeleteConfirmation');
    }, 2000)
};
</script>
