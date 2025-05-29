<!-- <template>
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeModal">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 xl:w-2/5 shadow-lg rounded-md bg-white"
            @click.stop>
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                    <CheckCircle class="h-5 w-5 mr-2 text-green-600" />
                    Appliquer la sanction
                </h3>
                <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <X class="h-6 w-6" />
                </button>
            </div>

            <div class="mt-4 space-y-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <AlertTriangle class="h-5 w-5 text-yellow-500 mr-3 mt-0.5" />
                        <div>
                            <h4 class="text-sm font-medium text-yellow-800 mb-2">Confirmation d'application</h4>
                            <p class="text-sm text-yellow-700">
                                Vous êtes sur le point d'appliquer une sanction de type
                                <strong>{{ sanction.sanctionType }}</strong> à
                                <strong>{{ sanction.learner }}</strong> (Classe {{ sanction.class }}).
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-3">Détails de la sanction</h4>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Motif</label>
                            <p class="text-sm text-gray-900">{{ sanction.reason }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Règle appliquée</label>
                            <p class="text-sm text-gray-900">{{ sanction.rule }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Type de sanction</label>
                                <span :class="[
                                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                                    getSanctionTypeColor(sanction.sanctionType)
                                ]">
                                    {{ sanction.sanctionType }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Durée estimée</label>
                                <p class="text-sm text-gray-900">{{ getDuration(sanction.sanctionType) }} jour{{
                                    getDuration(sanction.sanctionType) > 1 ? 's' : '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-3">Détails d'application</h4>
                    <div class="space-y-4">
                        <div>
                            <label for="appliedBy" class="block text-sm font-medium text-gray-700 mb-2">
                                Appliquée par <span class="text-red-500">*</span>
                            </label>
                            <input id="appliedBy" v-model="appliedBy" type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Nom de la personne qui applique la sanction" />
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Notes additionnelles (optionnel)
                            </label>
                            <textarea id="notes" v-model="notes" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Commentaires ou informations supplémentaires..."></textarea>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-3">Aperçu de l'application</h4>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="space-y-2">
                            <div class="flex items-center text-sm">
                                <Calendar class="h-4 w-4 text-blue-600 mr-2" />
                                <span class="text-blue-900">
                                    <strong>Date d'application:</strong> {{ formatDate(new Date()) }}
                                </span>
                            </div>
                            <div class="flex items-center text-sm">
                                <Clock class="h-4 w-4 text-blue-600 mr-2" />
                                <span class="text-blue-900">
                                    <strong>Date de fin prévue:</strong> {{ formatDate(getEndDate()) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-gray-200 space-x-3">
                <button @click="closeModal"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Annuler
                </button>
                <button @click="confirmApplication" :disabled="!appliedBy.trim()"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 disabled:bg-green-400 text-white text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 disabled:cursor-not-allowed flex items-center">
                    <CheckCircle class="h-4 w-4 mr-2" />
                    Confirmer l'application
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import {
    CheckCircle,
    X,
    AlertTriangle,
    Calendar,
    Clock
} from 'lucide-vue-next';

const props = defineProps({
    sanction: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['close', 'confirm']);

const appliedBy = ref('');
const notes = ref('');

const closeModal = () => {
    emit('close');
};

const confirmApplication = () => {
    if (appliedBy.value.trim()) {
        emit('confirm', props.sanction, appliedBy.value.trim(), notes.value.trim());
    }
};

const getSanctionTypeColor = (type) => {
    const colors = {
        'Avertissement': 'bg-yellow-100 text-yellow-800',
        'Blâme': 'bg-orange-100 text-orange-800',
        'Exclusion': 'bg-red-100 text-red-800'
    };
    return colors[type] || 'bg-gray-100 text-gray-800';
};

const getDuration = (type) => {
    const durations = {
        'Avertissement': 7,
        'Blâme': 14,
        'Exclusion': 21
    };
    return durations[type] || 7;
};

const getEndDate = () => {
    const duration = getDuration(props.sanction.sanctionType);
    return new Date(Date.now() + duration * 24 * 60 * 60 * 1000);
};

const formatDate = (date) => {
    return new Intl.DateTimeFormat('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    }).format(date);
};
</script>

<style scoped>
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
</style> -->

<template>
    <!-- Modal Header -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-200">
        <h3 class="text-xl font-semibold text-charcoal-900 flex items-center">
            <CheckCircle class="h-5 w-5 mr-2 text-teal-600" />
            Appliquer la sanction
        </h3>
        <!-- ... rest of header ... -->
    </div>

    <!-- Warning Box -->
    <div class="bg-golden-yellow-50 border border-golden-yellow-200 rounded-lg p-4">
        <div class="flex items-start">
            <AlertTriangle class="h-5 w-5 text-golden-yellow mr-3 mt-0.5" />
            <div>
                <h4 class="text-sm font-medium text-golden-yellow-800 mb-2">Confirmation d'application</h4>
                <p class="text-sm text-golden-yellow-700">
                    Vous êtes sur le point d'appliquer une sanction de type
                    <strong>{{ sanction.sanctionType }}</strong> à
                    <strong>{{ sanction.learner }}</strong> (Classe {{ sanction.class }}).
                </p>
            </div>
        </div>
    </div>

    <!-- Form inputs with updated focus colors -->
    <input id="appliedBy" v-model="appliedBy" type="text"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
        placeholder="Nom de la personne qui applique la sanction" />

    <textarea id="notes" v-model="notes" rows="3"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
        placeholder="Commentaires ou informations supplémentaires..."></textarea>

    <!-- Timeline Preview -->
    <div class="bg-teal-50 rounded-lg p-4">
        <div class="space-y-2">
            <div class="flex items-center text-sm">
                <Calendar class="h-4 w-4 text-teal-600 mr-2" />
                <span class="text-teal-900">
                    <strong>Date d'application:</strong> {{ formatDate(new Date()) }}
                </span>
            </div>
            <div class="flex items-center text-sm">
                <Clock class="h-4 w-4 text-teal-600 mr-2" />
                <span class="text-teal-900">
                    <strong>Date de fin prévue:</strong> {{ formatDate(getEndDate()) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Modal Footer -->
    <div class="flex items-center justify-end pt-4 border-t border-gray-200 space-x-3">
        <button @click="closeModal"
            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
            Annuler
        </button>
        <button @click="confirmApplication" :disabled="!appliedBy.trim()"
            class="px-4 py-2 bg-teal-600 hover:bg-teal-700 disabled:bg-teal-400 text-white text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 disabled:cursor-not-allowed flex items-center">
            <CheckCircle class="h-4 w-4 mr-2" />
            Confirmer l'application
        </button>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import {
    CheckCircle,
    X,
    AlertTriangle,
    Calendar,
    Clock
} from 'lucide-vue-next';

const props = defineProps({
    sanction: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['close', 'confirm']);

const appliedBy = ref('');
const notes = ref('');

const closeModal = () => {
    emit('close');
};

const confirmApplication = () => {
    if (appliedBy.value.trim()) {
        emit('confirm', props.sanction, appliedBy.value.trim(), notes.value.trim());
    }
};

const getSanctionTypeColor = (type) => {
    const colors = {
        'Avertissement': 'bg-yellow-100 text-yellow-800',
        'Blâme': 'bg-orange-100 text-orange-800',
        'Exclusion': 'bg-red-100 text-red-800'
    };
    return colors[type] || 'bg-gray-100 text-gray-800';
};

const getDuration = (type) => {
    const durations = {
        'Avertissement': 7,
        'Blâme': 14,
        'Exclusion': 21
    };
    return durations[type] || 7;
};

const getEndDate = () => {
    const duration = getDuration(props.sanction.sanctionType);
    return new Date(Date.now() + duration * 24 * 60 * 60 * 1000);
};

const formatDate = (date) => {
    return new Intl.DateTimeFormat('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    }).format(date);
};
</script>

<style scoped>
/* Brand Colors */
.text-charcoal-900 {
    color: #1E1E1E;
}

.text-teal-600 {
    color: #00B3C6;
}

.text-teal-900 {
    color: #006B7A;
}

.bg-teal-50 {
    background-color: #F0FAFB;
}

.bg-teal-600 {
    background-color: #00B3C6;
}

.bg-teal-700 {
    background-color: #008A9B;
}

.bg-teal-400 {
    background-color: #33C6D6;
}

.text-golden-yellow {
    color: #D99200;
}

.text-golden-yellow-700 {
    color: #B37700;
}

.text-golden-yellow-800 {
    color: #996600;
}

.bg-golden-yellow-50 {
    background-color: #FFFBF0;
}

.border-golden-yellow-200 {
    border-color: #FFE999;
}

.focus\:ring-teal-500:focus {
    --tw-ring-color: #00B3C6;
}

.focus\:border-teal-500:focus {
    border-color: #00B3C6;
}

.focus\:ring-teal-500:focus {
    --tw-ring-color: #00B3C6;
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
</style>