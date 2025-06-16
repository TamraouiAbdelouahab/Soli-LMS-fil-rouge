<template>
    <!-- Modal Overlay -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeModal">
        <!-- Modal Container -->
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 xl:w-2/5 shadow-lg rounded-md bg-white"
            @click.stop>
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-charcoal-900 flex items-center">
                    <Eye class="h-5 w-5 mr-2 text-teal-600" />
                    Détails de la sanction
                </h3>
                <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <X class="h-6 w-6" />
                </button>
            </div>

            <!-- Modal Body -->
            <div class="mt-4 space-y-6">
                <!-- Sanction Header -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div :class="[
                            'h-12 w-12 rounded-full flex items-center justify-center mr-4',
                            getIconBgClass(sanction.regle.sanction_type)
                        ]">
                            <component :is="getSanctionIcon(sanction.regle.sanction_type)" class="h-6 w-6 text-white" />
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-charcoal-900">{{ sanction.regle.sanction_type }}</h4>
                        </div>
                    </div>
                    <span :class="[
                        'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium',
                        isActive ? 'bg-teal-100 text-teal-800' : 'bg-gray-100 text-gray-800'
                    ]">
                        <span :class="[
                            'h-2 w-2 rounded-full mr-1',
                            isActive ? 'bg-teal-500' : 'bg-gray-400'
                        ]"></span>
                        {{ isActive ? 'Active' : 'Expirée' }}
                    </span>
                </div>

                <!-- Dates Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-light-blue-50 rounded-lg p-4 border border-light-blue-200">
                        <div class="flex items-center mb-2">
                            <Calendar class="h-4 w-4 text-teal-600 mr-2" />
                            <label class="text-sm font-medium text-gray-700">Date de début</label>
                        </div>
                        <p class="text-lg font-semibold text-charcoal-900">{{ formatDate(sanction.date_debut) }}</p>
                        <p class="text-sm text-gray-500">{{ getRelativeDate(sanction.date_debut) }}</p>
                    </div>

                    <div class="bg-light-blue-50 rounded-lg p-4 border border-light-blue-200">
                        <div class="flex items-center mb-2">
                            <Calendar class="h-4 w-4 text-teal-600 mr-2" />
                            <label class="text-sm font-medium text-gray-700">Date de fin</label>
                        </div>
                        <p class="text-lg font-semibold text-charcoal-900">{{ formatDate(sanction.date_fin) }}</p>
                        <p class="text-sm text-gray-500">
                            {{ isActive ? `Se termine dans ${getRemainingDays(sanction.date_fin)} jours` : 'Terminée' }}
                        </p>
                    </div>
                </div>

                <!-- Duration Card -->
                <div class="bg-teal-50 rounded-lg p-4 border border-teal-200">
                    <div class="flex items-center">
                        <Clock class="h-5 w-5 text-teal-600 mr-3" />
                        <div>
                            <p class="text-sm font-medium text-teal-900">Durée de la sanction</p>
                            <p class="text-lg font-semibold text-teal-800">{{ getDurationText(sanction.date_debut,
                                sanction.date_fin) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div>
                    <div class="flex items-center mb-3">
                        <FileText class="h-4 w-4 text-gray-600 mr-2" />
                        <label class="text-sm font-medium text-gray-700">Description de la sanction</label>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm text-charcoal-900 leading-relaxed">{{ sanction.regle.description }}</p>
                    </div>
                </div>

                <!-- Rule Section -->
                <div>
                    <div class="flex items-center mb-3">
                        <BookOpen class="h-4 w-4 text-gray-600 mr-2" />
                        <label class="text-sm font-medium text-gray-700">Règle appliquée</label>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm font-medium text-charcoal-900">{{ sanction.regle.titre }}</p>
                    </div>
                </div>

                <!-- Status Timeline -->
                <div>
                    <div class="flex items-center mb-3">
                        <Activity class="h-4 w-4 text-gray-600 mr-2" />
                        <label class="text-sm font-medium text-gray-700">Chronologie</label>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="space-y-3">
                            <!-- Start Event -->
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                                    <Play class="h-4 w-4 text-teal-600" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-charcoal-900">Sanction appliquée</p>
                                    <p class="text-xs text-gray-500">{{ formatDateTime(sanction.date_debut) }}</p>
                                </div>
                            </div>

                            <!-- Current Status -->
                            <div class="flex items-center">
                                <div :class="[
                                    'flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center',
                                    isActive ? 'bg-golden-yellow-100' : 'bg-gray-100'
                                ]">
                                    <component :is="isActive ? Clock : CheckCircle" :class="[
                                        'h-4 w-4',
                                        isActive ? 'text-golden-yellow' : 'text-gray-400'
                                    ]" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-charcoal-900">
                                        {{ isActive ? 'En cours' : 'Terminée' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ isActive ? 'Sanction active' : formatDateTime(sanction.date_fin) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar (for active sanctions) -->
                <div v-if="isActive" class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Progression</span>
                        <span class="text-sm text-gray-500">{{ Math.round(getProgressPercentage()) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-teal-600 h-2 rounded-full transition-all duration-300"
                            :style="{ width: getProgressPercentage() + '%' }"></div>
                    </div>
                    <p class="text-xs text-gray-500 text-center">
                        {{ getRemainingDays(sanction.date_fin) }} jour{{ getRemainingDays(sanction.date_fin) > 1 ? 's' :
                            '' }} restant{{ getRemainingDays(sanction.date_fin) > 1 ? 's' : '' }}
                    </p>
                </div>
            </div>

            <div class="mt-4 flex flex-row-reverse">
                <button type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    @click="closeModal">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import {
    Eye,
    X,
    Calendar,
    Clock,
    FileText,
    BookOpen,
    Activity,
    Play,
    CheckCircle,
    Download,
    Printer,
    AlertTriangle,
    Ban,
    Clock3
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
    getDurationText: {
        type: Function,
        required: true
    },
    getRemainingDays: {
        type: Function,
        required: true
    },
    getIconBgClass: {
        type: Function,
        required: true
    },
    getSanctionIcon: {
        type: Function,
        required: true
    }
});

const emit = defineEmits(['close']);

// Computed property to check if the sanction is active
const isActive = computed(() => {
    return new Date(props.sanction.date_fin) > new Date();
});

// Methods
const closeModal = () => {
    emit('close');
};

const formatDateTime = (date) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const getRelativeDate = (date) => {
    const now = new Date();
    const targetDate = new Date(date);
    const diffTime = Math.abs(now - targetDate);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    if (targetDate < now) {
        return `Il y a ${diffDays} jour${diffDays > 1 ? 's' : ''}`;
    } else {
        return `Dans ${diffDays} jour${diffDays > 1 ? 's' : ''}`;
    }
};

const getProgressPercentage = () => {
    if (!isActive.value) return 100;

    const start = new Date(props.sanction.date_debut);
    const end = new Date(props.sanction.date_fin);
    const now = new Date();

    const totalDuration = end - start;
    const elapsed = now - start;

    return Math.min(100, Math.max(0, (elapsed / totalDuration) * 100));
};

</script>

<style scoped>
.bg-red-orange {
    background-color: #FF5F33;
}

.bg-orange-500 {
    background-color: #F97316;
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

/* Print styles */
@media print {
    .fixed {
        position: static !important;
    }

    .bg-gray-600 {
        display: none !important;
    }

    .shadow-lg {
        box-shadow: none !important;
    }
}
</style>