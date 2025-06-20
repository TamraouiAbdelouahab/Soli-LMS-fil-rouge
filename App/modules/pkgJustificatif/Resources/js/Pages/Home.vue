<template>
    <Head title="Home" />
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-4 md:p-6">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Gestion des justificatifs</h1>
                <button
                    @click="addModalVisible = true"
                    class="bg-blue-500 text-white px-4 py-2 rounded">
                    <!-- Ajouter un justification -->
                    +
                </button>
            </div>
            <DeleteConfirmMessage @closeDeleteConfirmation="deleteConfirmationMessageVisible = false"
                            v-show = "deleteConfirmationMessageVisible" />
            <!-- <DeleteConfirm @closeConfirmation = "deleteConfirmationVisible = false"
                            v-show="deleteConfirmationVisible" /> -->
            <AddConfirm @closeAddConfirmationVisible="addConfirmationVisible = false"
                            v-show = "addConfirmationVisible" />
            <form class="mb-3" @submit.prevent="Filter()" >
                <!-- apprenant -->
                <div class="mb-2 flex justify-end">
                        <button type="button" @click="filterVisible = !filterVisible" :class="((filterVisible) ? 'bg-blue-600 hover:bg-white text-white hover:text-gray-900':'bg-white hover:bg-blue-700 text-gray-900 hover:text-white') + ' font-medium py-2 px-2 rounded-lg shadow'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 01.8 1.6L15 12.4V19a1 1 0 01-1.45.9l-4-2A1 1 0 019 17v-4.6L3.2 5.6A1 1 0 013 4z" />
                            </svg>
                        </button>
                </div>
                <div class="flex items-center gap-4" v-if="filterVisible">
                    <div class="w-1/4" >
                        <DropDown @selectElement="SelectApprenant" :apprenants="props.apprenants" :apprenant_id="formFilter.apprenant_id" />
                    </div>
                    <div class="w-1/4">
                        <select name="status" id="status" v-model="formFilter.status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2">
                            <option v-for="[key, status] in Object.entries(statuses)" :value="key" :key="key">{{status}}</option>
                        </select>
                    </div>
                    <div class="w-1/4">
                        <input  type="text"
                                onfocus="(this.type='date')"
                                onblur="(this.type='text')"
                                id="dateDebut"
                                name="dateDebut"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
                                placeholder="Date de fin"
                                v-model = "formFilter.dateDebut"
                            />
                    </div>
                    <div class="w-1/4">
                        <input  type="text"
                                onfocus="(this.type='date')"
                                onblur="(this.type='text')"
                                id="dateFin"
                                name="dateFin"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
                                placeholder="Date de fin"
                                v-model="formFilter.dateFin"
                            />
                    </div>
                </div>
                <div class="flex justify-end" v-if="filterVisible">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow">
                        Filtrer
                    </button>
                </div>
            </form>
            <JustificationsTable :justifications="props.justifications" class="mb-6"
                                    @openDeleteConfirmation="deleteConfirmationMessageVisible = true"
                                    @closeDeleteConfirmation="deleteConfirmationMessageVisible = false"
                                    @openUpdateModal="handleOpenUpdateModal"
                                    />
            <UpdateConfirmMessage @closeUpdateConfirmation = "updateConfirmationMessageVisible = false"
                            v-show="updateConfirmationMessageVisible"
                            />
            </div>
        <AddModal :show="addModalVisible" :reasons="props.reasons" :groups="props.groups  "
                @close="addModalVisible = false"
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
import { Head,router,useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';
import JustificationsTable from '../Components/Home/JustificationsTable.vue';
import AddModal from '../Components/Home/AddJustificationModal.vue';
import UpdateModal from '../Components/Home/updateJustificationModal.vue';
import UpdateConfirmMessage from '../Components/Home/updateConfirmMessage.vue';
import DeleteConfirmMessage from '../Components/Home/deleteConfirmMessage.vue';
import AddConfirm from '../Components/Home/addConfirm.vue';
import DropDown from '../Components/Home/DropDown.vue';


const props = defineProps({
    justifications:Object,
    apprenants:Object,
    reasons:Object,
    groups:Object,
    filters:Object
});
const addModalVisible = ref(false)
const deleteConfirmationMessageVisible = ref(false)
const addConfirmationVisible = ref(false)
const updateModalVisible = ref(false)
const updateConfirmationMessageVisible = ref(false)
const UpdateModalJustification = ref(props.justifications.data[0]);
function handleOpenUpdateModal(id) {
    updateModalVisible.value = true;
    UpdateModalJustification.value = props.justifications.data.find(j => j.id == id);
}



// Filter
const statuses = ref({
"":"status",
"EN_ATTENTE": "en attente",
"ACCEPTE": "accepte",
"REJETE": "rejete",
});
const formFilter = useForm({
    apprenant_id: props.filters?.apprenant_id || '',
    status: props.filters?.status || '',
    dateDebut: props.filters?.dateDebut || '',
    dateFin: props.filters?.dateFin || '',
});
const filterVisible = ref(false);
if(formFilter.apprenant_id != '' || formFilter.status != '' || formFilter.dateDebut != '' || formFilter.dateFin != '')
    filterVisible.value = true;
function SelectApprenant(value) {
    formFilter.apprenant_id = value;
    console.log(formFilter)
}
function Filter() {
    router.visit(route('Justificatifs.home',formFilter));
}

</script>
