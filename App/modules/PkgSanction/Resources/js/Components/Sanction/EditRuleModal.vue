<template>
    <!-- Modal Overlay -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeModal">
        <!-- Modal Container -->
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 xl:w-2/5 shadow-lg rounded-md bg-white"
            @click.stop>
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                    <Edit class="h-5 w-5 mr-2 text-blue-600" />
                    Modifier la Règle
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
                            errors.titre ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400 focus:border-blue-500'
                        ]" placeholder="Ex: Règle d'absentéisme niveau 1" />
                        <p v-if="errors.titre" class="mt-1 text-sm text-red-600">{{ errors.titre }}</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" v-model="form.description" rows="3" :class="[
                            'w-full px-3 py-2 border rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-vertical',
                            errors.description ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400 focus:border-blue-500'
                        ]" placeholder="Décrivez les conditions et modalités de cette règle..."></textarea>
                        <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description }}</p>
                    </div>

                    <!-- Numeric Fields Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Absences Maximum -->
                        <div>
                            <label for="absencesMax" class="block text-sm font-medium text-gray-700 mb-2">
                                Absences Max <span class="text-red-500">*</span>
                            </label>
                            <input id="absencesMax" v-model.number="form.absencesMax" type="number" min="1" :class="[
                                'w-full px-3 py-2 border rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500',
                                errors.absencesMax ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400 focus:border-blue-500'
                            ]" placeholder="5" />
                            <p v-if="errors.absencesMax" class="mt-1 text-sm text-red-600">{{ errors.absencesMax }}</p>
                        </div>

                        <!-- Seuil de Notification -->
                        <div>
                            <label for="seuilDeNotification" class="block text-sm font-medium text-gray-700 mb-2">
                                Seuil Notif. <span class="text-red-500">*</span>
                            </label>
                            <input id="seuilDeNotification" v-model.number="form.seuilDeNotification" type="number"
                                min="1" :class="[
                                    'w-full px-3 py-2 border rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500',
                                    errors.seuilDeNotification ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400 focus:border-blue-500'
                                ]" placeholder="3" />
                            <p v-if="errors.seuilDeNotification" class="mt-1 text-sm text-red-600">{{
                                errors.seuilDeNotification }}</p>
                        </div>

                        <!-- Durée de la Sanction -->
                        <div>
                            <label for="dureeSanction" class="block text-sm font-medium text-gray-700 mb-2">
                                Durée (jours) <span class="text-red-500">*</span>
                            </label>
                            <input id="dureeSanction" v-model.number="form.dureeSanction" type="number" min="1" :class="[
                                'w-full px-3 py-2 border rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500',
                                errors.dureeSanction ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400 focus:border-blue-500'
                            ]" placeholder="7" />
                            <p v-if="errors.dureeSanction" class="mt-1 text-sm text-red-600">{{ errors.dureeSanction }}
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
                    {{ isSubmitting ? 'Mise à jour...' : 'Mettre à jour' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { Edit, X, Save, Loader2 } from 'lucide-vue-next';

// Props
const props = defineProps({
    rule: {
        type: Object,
        required: true
    }
});

// Emits
const emit = defineEmits(['close', 'submit']);

// Form data
const form = reactive({
    titre: '',
    description: '',
    absencesMax: null,
    seuilDeNotification: null,
    dureeSanction: null
});

// Form state
const errors = ref({});
const isSubmitting = ref(false);

// Computed properties
const isFormValid = computed(() => {
    return form.titre.trim() &&
        form.description.trim() &&
        form.absencesMax > 0 &&
        form.seuilDeNotification > 0 &&
        form.dureeSanction > 0 &&
        form.seuilDeNotification < form.absencesMax;
});

// Methods
const validateForm = () => {
    const newErrors = {};

    if (!form.titre.trim()) {
        newErrors.titre = 'Le titre est requis';
    } else if (form.titre.trim().length < 3) {
        newErrors.titre = 'Le titre doit contenir au moins 3 caractères';
    }

    if (!form.description.trim()) {
        newErrors.description = 'La description est requise';
    } else if (form.description.trim().length < 10) {
        newErrors.description = 'La description doit contenir au moins 10 caractères';
    }

    if (!form.absencesMax || form.absencesMax <= 0) {
        newErrors.absencesMax = 'Le nombre maximum d\'absences doit être un entier positif';
    }

    if (!form.seuilDeNotification || form.seuilDeNotification <= 0) {
        newErrors.seuilDeNotification = 'Le seuil de notification doit être un entier positif';
    } else if (form.absencesMax && form.seuilDeNotification >= form.absencesMax) {
        newErrors.seuilDeNotification = 'Le seuil doit être inférieur au maximum d\'absences';
    }

    if (!form.dureeSanction || form.dureeSanction <= 0) {
        newErrors.dureeSanction = 'La durée de la sanction doit être un entier positif';
    }

    errors.value = newErrors;
    return Object.keys(newErrors).length === 0;
};

const handleSubmit = async () => {
    if (!validateForm()) {
        return;
    }

    isSubmitting.value = true;

    try {
        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000));

        emit('submit', { ...form });

    } catch (error) {
        console.error('Erreur lors de la mise à jour:', error);
    } finally {
        isSubmitting.value = false;
    }
};

const closeModal = () => {
    emit('close');
};

// Initialize form with rule data
onMounted(() => {
    form.titre = props.rule.titre;
    form.description = props.rule.description;
    form.absencesMax = props.rule.absencesMax;
    form.seuilDeNotification = props.rule.seuilDeNotification;
    form.dureeSanction = props.rule.dureeSanction;
});
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