<template>
    <ConfirmDelete @closeConfirmation = "deleteConfirmationVisible = false"
                v-show="deleteConfirmationVisible"
                @confirm="confirmDeleteJustification"
                @cancel = "deleteConfirmationVisible = false"
                />
    <UpdateConfirmMessage @closeUpdateConfirmation = "updateConfirmationMessageVisible = false"
                            v-show="updateConfirmationMessageVisible" />
    <UpdateJustificationModal :show="updateModalVisible" :reasons="props.reasons" :groups="props.groups" :justification="UpdateModalJustification"
                @close="updateModalVisible = false"
                @openConfirmation="UpdateSuccess"
                @closeConfirmation="updateConfirmationMessageVisible = false"
                @closeUpdateConfirmationVisible="updateModalVisible = false"
                @openUpdateConfirmationVisible="updateModalVisible = true"
    />

    <DeleteConfirmMessage @closeDeleteConfirmation="deleteConfirmationMessageVisible = false"
                            v-show = "deleteConfirmationMessageVisible" />

    <div class="bg-white rounded-lg shadow p-4" id="justifications">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">justificatifs récentes</h2>
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
                    <tr v-for="(justification, index) in props.justifications.slice(-6,-1).reverse()" :key="index">
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
                                <button class="text-blue-600 hover:text-blue-800"
                                        @click="handleOpenUpdateModal(justification.id)"
                                >
                                    <Edit class="h-4 w-4" />
                                </button>
                                <button class="text-red-600 hover:text-red-800"
                                        @click="deleteJustification(justification.id)"
                                >
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
                <Link
                    :href="route('Justificatifs.home')"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-900 px-3 py-1 rounded-md text-sm flex items-center">
                    Voir plus
                </Link>

            </div>
        </div>
    </div>
</template>

<script setup>
import { FileText, FileSpreadsheet, Edit, Trash2 } from 'lucide-vue-next';
import { Link,router } from '@inertiajs/vue3';
import { ref } from 'vue';
import ConfirmDelete from "../Home/deleteConfirm.vue"
import DeleteConfirmMessage from "../Home/deleteConfirmMessage.vue"
import UpdateJustificationModal from "../Home/updateJustificationModal.vue"
import UpdateConfirmMessage from "../Home/updateConfirmMessage.vue"
const deleteConfirmationVisible = ref(false)
const deleteConfirmationMessageVisible = ref(false)
const updateConfirmationMessageVisible = ref(false)
const updateModalVisible = ref(false)
const idToDelete = ref(null);


const props = defineProps({
    justifications:Object,
    reasons:Object,
    groups:Object,
});

const deleteJustification = (id) => {
    idToDelete.value = id;
    deleteConfirmationVisible.value = true;
};
const confirmDeleteJustification = () => {
    router.delete(idToDelete.value)

    deleteConfirmationVisible.value = false;
    setTimeout(() => {
        deleteConfirmationMessageVisible.value = true;
    }, 1000);
    setTimeout(() => {
        deleteConfirmationMessageVisible.value = false;
    }, 2000)
};
const UpdateModalJustification = ref(props.justifications[0]);
function handleOpenUpdateModal(id) {
    updateModalVisible.value = true;
    UpdateModalJustification.value = props.justifications.find(j => j.id == id);
}

function UpdateSuccess() {
    router.visit("/justificatif/dashboard#justifications");
    updateConfirmationMessageVisible.value = true;
    setTimeout(() => {
        updateConfirmationMessageVisible.value = false;
        // router.push(route('Justificatifs.dashboard'));

    }, 2000)
}

</script>
