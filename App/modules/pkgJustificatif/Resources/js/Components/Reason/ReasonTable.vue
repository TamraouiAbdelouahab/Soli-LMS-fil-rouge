<template>
    <ConfirmDelete @closeConfirmation = "deleteConfirmationVisible = false"
                    v-show="deleteConfirmationVisible"
                    @confirm="confirmDeleteReason"
                    @cancel = "deleteConfirmationVisible = false"
                    />
    <div class="min-h-[calc(65vh)] max-h-[calc(70vh)]">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Les Raisons</h2>
            </div>
            <div class="overflow-x-auto" >
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 w-full">
                        <tr class="w-full">
                            <th class="px-4 py-3 w-1/7 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                id</th>
                            <th class="px-4 py-3 w-1/7 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                code</th>
                            <th class="px-4 py-3 w-1/7 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                libelle</th>
                            <th class="px-4 py-3 w-3/7 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                description</th>
                            <th class="px-4 py-3 w-1/7 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(reason, index) in props.reasons.data" :key="index">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{reason.id}}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{reason.code}}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{reason.libelle}}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{(reason.description == null)  ? reason.description : (reason.description.length <= 75) ? reason.description : reason.description.substring(0,75) + '...'}}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-800">
                                        <Edit class="h-4 w-4" @click="emit('openUpdateModal',reason.id)"
                                        />
                                    </button>
                                    <button class="text-red-600 hover:text-red-800"  @click="deleteReason(reason.id)" >
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
    <Pagination :Links="props.reasons.links" v-show="props.reasons.links.length > 3" />
</template>

<script setup>
import { FileText, FileSpreadsheet, Edit, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';
import Pagination from './pagination.vue';
import { router } from '@inertiajs/vue3'
import axios from 'axios'
import { Inertia } from '@inertiajs/inertia'

import ConfirmDelete from "./deleteConfirm.vue"
const props = defineProps({
    reasons: {
        type: Object,
        required: true
    }
});
const deleteConfirmationVisible = ref(false)
const idToDelete = ref(null);
const emit = defineEmits(['openDeleteConfirmation','closeDeleteConfirmation','openUpdateModal','openDeleteMessageError','closeDeleteConfirmation']);
const deleteReason = (id) => {
    idToDelete.value = id;
    deleteConfirmationVisible.value = true;
};
const confirmDeleteReason = () => {
    // router.delete(`/justificatif/reason/${idToDelete.value}`)
    // deleteConfirmationVisible.value = false;
    // setTimeout(() => {
    //     emit('openDeleteConfirmation');
    // }, 1000);
    // setTimeout(() => {
    //     emit('closeDeleteConfirmation');
    // }, 2000)
    console.log(idToDelete.value)
    axios.delete(route('reasons.destroy',idToDelete.value))
    .then(response => {
        deleteConfirmationVisible.value = false;
        props.reasons.data = props.reasons.data.filter(reason => reason.id !== idToDelete.value);

        setTimeout(() => {
            emit('openDeleteConfirmation');
            router.visit(route('reasons.home'))
        }, 1000);
        setTimeout(() => {
            emit('closeDeleteConfirmation');
        }, 2000)
        // props.reasons.value  = props.reasons.data.filter(reason => reason.id != idToDelete.value);
    })
    .catch(error => {
        if (error.response.status == 400) {
            deleteConfirmationVisible.value = false;
            setTimeout(() => {
            emit('openDeleteMessageError');
            }, 500);
            setTimeout(() => {
                emit('closeDeleteMessageError');
            }, 2500)
        }
    });
};
</script>
