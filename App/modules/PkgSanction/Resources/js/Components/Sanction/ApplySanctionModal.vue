<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white w-full max-w-xl rounded-lg shadow-lg p-6 relative">
            <!-- Close Button -->
            <button @click="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                <X class="h-5 w-5" />
            </button>

            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-charcoal-900 flex items-center">
                    <CheckCircle class="h-5 w-5 mr-2 text-teal-600" />
                    Appliquer la sanction
                </h3>
            </div>

            <!-- Warning Box -->
            <div class="bg-golden-yellow-50 border border-golden-yellow-200 rounded-lg p-4 mt-4">
                <div class="flex items-start">
                    <AlertTriangle class="h-5 w-5 text-golden-yellow mr-3 mt-0.5" />
                    <div>
                        <h4 class="text-sm font-medium text-golden-yellow-800 mb-2">Confirmation d'application</h4>
                        <p class="text-sm text-golden-yellow-700">
                            Vous êtes sur le point d'appliquer une sanction de type
                            <strong>{{ sanction.regle.sanction_type }}</strong> à
                            <strong>{{ sanction.absences[0].apprenant.nom }} {{ sanction.absences[0].apprenant.prenom
                                }}</strong>
                            (Groupe {{ sanction.absences[0].apprenant.groupes[0].nom }}).
                        </p>
                    </div>
                </div>
            </div>

            <!-- Timeline Preview -->
            <div class="bg-teal-50 border border-teal-100 rounded-lg p-4 mt-4 mb-4">
                <div class="space-y-2">
                    <div class="flex items-center text-sm">
                        <Calendar class="h-4 w-4 text-teal-600 mr-2" />
                        <span class="text-teal-900">
                            <strong>Date d'application:</strong> {{ formatDate(today) }}
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
                <button @click="confirmApplication"
                    class="px-4 py-2 bg-teal-600 hover:bg-teal-700 disabled:bg-teal-400 text-white text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 disabled:cursor-not-allowed flex items-center">
                    <CheckCircle class="h-4 w-4 mr-2" />
                    Confirmer l'application
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
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
    },
    formatDate: {
        type: Function,
        required: true
    },
});

const emit = defineEmits(['close', 'confirm']);

const closeModal = () => {
    emit('close');
};

const confirmApplication = () => {
    emit('confirm', props.sanction);
};

const today = new Date();

const getEndDate = () => {
    const duration = props.sanction?.regle?.duree || 0;
    const endDate = new Date(today);
    endDate.setDate(endDate.getDate() + duration);
    return endDate;
};

</script>

<style scoped>
/* .focus\:ring-teal-500:focus {
    --tw-ring-color: #00B3C6;
}

.focus\:border-teal-500:focus {
    border-color: #00B3C6;
} */

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
