<template>
    <div>
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