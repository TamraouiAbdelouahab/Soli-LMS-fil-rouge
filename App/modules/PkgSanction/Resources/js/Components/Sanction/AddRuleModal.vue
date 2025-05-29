<template>
    <!-- Modal Overlay -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeModal">
        <!-- Modal Container -->
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 xl:w-2/5 shadow-lg rounded-md bg-white"
            @click.stop>
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                    <Plus class="h-5 w-5 mr-2 text-blue-600" />
                    Nouvelle Règle de Sanction
                </h3>
                <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <X class="h-6 w-6" />
                </button>
            </div>

            <!-- Modal Body -->
            <div class="mt-4 max-h-96 overflow-y-auto">
                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <!-- Titre -->
                    <div>
                        <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                            Titre <span class="text-red-500">*</span>
                        </label>
                        <input id="titre" v-model="form.titre" type="text" :class="[
                            'w-full px-3 py-2 border rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500',
                            form.errors.titre ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400 focus:border-blue-500'
                        ]" placeholder="Ex: Règle d'absentéisme niveau 1" />
                        <p v-if="form.errors.titre" class="mt-1 text-sm text-red-600">{{ form.errors.titre }}</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description" v-model="form.description" rows="3" :class="[
                            'w-full px-3 py-2 border rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-vertical',
                            form.errors.description ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400 focus:border-blue-500'
                        ]" placeholder="Décrivez les conditions et modalités de cette règle..."></textarea>
                        <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description
                            }}</p>
                    </div>

                    <!-- Status Toggle -->
                    <div class="flex items-center">
                        <label class="block text-sm font-medium text-gray-700 mr-4">
                            Statut
                        </label>
                        <div class="flex items-center">
                            <button type="button" @click="form.est_actif = true" :class="[
                                'px-3 py-1 rounded-l-md border',
                                form.est_actif ? 'bg-green-500 text-white border-green-600' : 'bg-gray-100 text-gray-700 border-gray-300'
                            ]">
                                Actif
                            </button>
                            <button type="button" @click="form.est_actif = false" :class="[
                                'px-3 py-1 rounded-r-md border',
                                !form.est_actif ? 'bg-red-500 text-white border-red-600' : 'bg-gray-100 text-gray-700 border-gray-300'
                            ]">
                                Inactif
                            </button>
                        </div>
                    </div>
                    <p v-if="form.errors.est_actif" class="mt-1 text-sm text-red-600">{{ form.errors.est_actif }}</p>

                    <!-- Numeric Fields Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Absences Maximum -->
                        <div>
                            <label for="absences_max" class="block text-sm font-medium text-gray-700 mb-2">
                                Absences Max <span class="text-red-500">*</span>
                            </label>
                            <input id="absences_max" v-model.number="form.absences_max" type="number" min="1" :class="[
                                'w-full px-3 py-2 border rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500',
                                form.errors.absences_max ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400 focus:border-blue-500'
                            ]" placeholder="5" />
                            <p v-if="form.errors.absences_max" class="mt-1 text-sm text-red-600">{{
                                form.errors.absences_max }}
                            </p>
                        </div>

                        <!-- Seuil de Notification -->
                        <div>
                            <label for="seuil_de_notification" class="block text-sm font-medium text-gray-700 mb-2">
                                Seuil Notif. <span class="text-red-500">*</span>
                            </label>
                            <input id="seuil_de_notification" v-model.number="form.seuil_de_notification" type="number"
                                min="1" :class="[
                                    'w-full px-3 py-2 border rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500',
                                    form.errors.seuil_de_notification ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400 focus:border-blue-500'
                                ]" placeholder="3" />
                            <p v-if="form.errors.seuil_de_notification" class="mt-1 text-sm text-red-600">{{
                                form.errors.seuil_de_notification }}</p>
                        </div>

                        <!-- Durée de la Sanction -->
                        <div>
                            <label for="duree_sanction" class="block text-sm font-medium text-gray-700 mb-2">
                                Durée (jours) <span class="text-red-500">*</span>
                            </label>
                            <input id="duree_sanction" v-model.number="form.duree_sanction" type="number" min="1"
                                :class="[
                                    'w-full px-3 py-2 border rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500',
                                    form.errors.duree_sanction ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400 focus:border-blue-500'
                                ]" placeholder="7" />
                            <p v-if="form.errors.duree_sanction" class="mt-1 text-sm text-red-600">{{
                                form.errors.duree_sanction
                                }}
                            </p>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                        <div class="flex items-start">
                            <Info class="h-4 w-4 text-blue-500 mr-2 mt-0.5 flex-shrink-0" />
                            <p class="text-sm text-blue-700">
                                Le seuil de notification doit être inférieur au nombre maximum d'absences.
                            </p>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end pt-4 border-t border-gray-200 space-x-3">
                <button type="button" @click="closeModal" :disabled="isSubmitting"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 disabled:opacity-50">
                    Annuler
                </button>
                <button @click="handleSubmit" :disabled="isSubmitting || !isFormValid"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:cursor-not-allowed flex items-center">
                    <Loader2 v-if="isSubmitting" class="h-4 w-4 mr-2 animate-spin" />
                    <Save v-else class="h-4 w-4 mr-2" />
                    {{ isSubmitting ? 'Enregistrement...' : 'Enregistrer' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Plus, X, Info, Save, Loader2 } from 'lucide-vue-next';

// Emits
const emit = defineEmits(['close', 'submit']);

// Form data
const form = useForm({
    titre: '',
    description: '',
    absences_max: null,
    seuil_de_notification: null,
    duree_sanction: null,
    est_actif: true
});

// Form state
const errors = ref({});
const isSubmitting = ref(false);

// Computed properties
const isFormValid = computed(() => {
    return form.titre.trim() &&
        form.absences_max > 0 &&
        form.seuil_de_notification > 0 &&
        form.duree_sanction > 0 &&
        form.seuil_de_notification < form.absences_max;
});


const handleSubmit = () => {
    form.post(route('sanction.rules.store'), {
        preserveScroll: true,
        onSuccess: () => {
            emit('submit');
            form.reset();
            closeModal();
        }
    });
};

const closeModal = () => {
    emit('close');
};

</script>

<style scoped>
/* Custom styles for number input arrows */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
}

/* Modal animation */
@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.relative {
    animation: modalSlideIn 0.3s ease-out;
}

/* Loading spinner */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>