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
            <JustificationsTable :justifications="props.justifications" class="mb-6" />
        </div>
         <Modal :show="modalVisible" @close="modalVisible = false" />
    </AuthenticatedLayout>
</template>


<script setup>
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';
import JustificationsTable from '../Components/Home/JustificationsTable.vue';
import Modal from '../Components/Home/AddJustificationModal.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    justifications:Object,
    apprenants:Object,
});
const modalVisible = ref(false)
</script>
