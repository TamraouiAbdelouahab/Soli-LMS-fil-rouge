<template>
    <Head title="Home" />
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-4 md:p-6">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Gestion des justificatifs</h1>
                <button
                    @click="modalVisible = true"
                    class="bg-blue-500 text-white px-4 py-2 rounded">
                    <!-- Ajouter un justification -->
                    +
                </button>
            </div>
            <ModifyConfirm @closeConfirmation="ConfiredMessage = false"
                            v-show = "ConfiredMessage" />
            <DeleteConfirmMessage @closeDeleteConfirmation="deleteConfirmationMessageVisible = false"
                            v-show = "deleteConfirmationMessageVisible" />
            <DeleteConfirm @closeConfirmation = "deleteConfirmationVisible = false"
                            v-show="deleteConfirmationVisible" />
            <AddConfirm @closeAddConfirmationVisible="addConfirmationVisible = false"
                            v-show = "addConfirmationVisible" />
            <JustificationsTable :justifications="props.justifications" class="mb-6"
                                    @openDeleteConfirmation="deleteConfirmationMessageVisible = true"
                                    @closeDeleteConfirmation="deleteConfirmationMessageVisible = false"
                                    @openUpdateModal="handleOpenUpdateModal"

                                    />
            </div>
         <AddModal :show="modalVisible" :reasons="props.reasons" :groups="props.groups "
                @close="modalVisible = false"
                @openConfirmation="ConfiredMessage=true"
                @closeConfirmation="ConfiredMessage = false"
                @closeAddConfirmationVisible="addConfirmationVisible = false"
                @openAddConfirmationVisible="addConfirmationVisible = true"
                />
         <UpdateModal :show="updateModalVisible" :reasons="props.reasons" :groups="props.groups" :justification="UpdateModalJustification"
                @close="updateModalVisible = false"
                @openConfirmation="updateConfirmationMessageVisible=true"
                @closeConfirmation="updateConfirmationMessageVisible = false"
                @closeUpdateConfirmationVisible="updateModalVisible = false"
                @openUpdateConfirmationVisible="updateModalVisible = true"
                />
    </AuthenticatedLayout>
</template>


<script setup>
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';
import JustificationsTable from '../Components/Home/JustificationsTable.vue';
import ModifyConfirm from '../Components/Home/Modal.vue';
import AddModal from '../Components/Home/AddJustificationModal.vue';
import UpdateModal from '../Components/Home/updateJustificationModal.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import DeleteConfirmMessage from '../Components/Home/deleteConfirmMessage.vue';
import AddConfirm from '../Components/Home/addConfirm.vue';
import DeleteConfirm from '../Components/Home/deleteConfirm.vue';

const props = defineProps({
    justifications:Object,
    apprenants:Object,
    reasons:Object,
    groups:Object
});
const modalVisible = ref(false)
const ConfiredMessage = ref(false)
const deleteConfirmationMessageVisible = ref(false)
const deleteConfirmationVisible = ref(false)
const addConfirmationVisible = ref(false)
const updateModalVisible = ref(false)
const updateConfirmationMessageVisible = ref(false)

const UpdateModalJustification = ref(props.justifications.data[0]);
console.log(props.justifications.data)
function handleOpenUpdateModal(id) {
    updateModalVisible.value = true;
    UpdateModalJustification.value = props.justifications.data.find(j => j.id == id);

}
</script>
