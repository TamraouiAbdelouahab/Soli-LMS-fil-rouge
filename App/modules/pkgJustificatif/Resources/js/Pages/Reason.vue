<template>
    <Head title="Reason" />
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-4 md:p-6">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Gestion des Raisons</h1>
                <button
                    @click="modalVisible = true"
                    class="bg-blue-500 text-white px-4 py-2 rounded">
                    <!-- Ajouter un justification -->
                    +
                </button>
            </div>
            <ReasonTable :reasons="props.reasons" class="mb-6"
                        @openDeleteConfirmation="deleteConfirmationMessageVisible = true"
                        @closeDeleteConfirmation="deleteConfirmationMessageVisible = false"
                         @openUpdateModal="handleOpenUpdateModal"
                         @openDeleteMessageError="deleteMessageErrorVisible = true"
                         @closeDeleteMessageError="deleteMessageErrorVisible = false"
            />
            <AddConfirm @closeAddConfirmationVisible="ConfirmMessageVisible = false"
                        v-show = "ConfirmMessageVisible"
                                />
            <DeleteConfirmationError    @closeDeleteConfirmation = "deleteMessageErrorVisible = false"
                            v-show="deleteMessageErrorVisible"
                                />
            <AddReasonModal :show="modalVisible" @close="modalVisible = false"
                            @closeConfirmation="ConfirmMessageVisible = false"
                            @openConfirmation="ConfirmMessageVisible = true"
                                />
            <UpdateReasonModal :show="updateModalVisible" :reason="UpdateModalReason" @close="updateModalVisible = false"
                                @closeConfirmation="ConfirmMessageVisible = false"
                                @openConfirmation="ConfirmMessageVisible = true"
                                />
            <DeleteConfirmationMessage @closeDeleteConfirmation = "deleteConfirmationMessageVisible = false"
                                v-show="deleteConfirmationMessageVisible"
                                />
        </div>
    </AuthenticatedLayout>
</template>


<script setup>
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';
import ReasonTable from '../Components/Reason/ReasonTable.vue';
import AddConfirm from '../Components/Reason/addConfirm.vue';
import AddReasonModal from '../Components/Reason/AddReasonModal.vue';
import DeleteConfirmationMessage from '../Components/Reason/deleteConfirmMessage.vue';
import UpdateReasonModal from '../Components/Reason/updateReasonModal.vue';
import DeleteConfirmationError from '../Components/Reason/deleteErrorMessage.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    reasons:Object,
});
const ConfirmMessageVisible = ref(false);
const modalVisible = ref(false);
const deleteConfirmationMessageVisible = ref(false);
const updateModalVisible = ref(false);
const deleteMessageErrorVisible = ref(false);
const UpdateModalReason = ref(props.reasons.data[0]);
function handleOpenUpdateModal(id) {
    updateModalVisible.value = true;
    UpdateModalReason.value = props.reasons.data.find(j => j.id == id);
    console.log(UpdateModalReason.value)
}

</script>
