<!-- <template>
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeModal">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 xl:w-2/5 shadow-lg rounded-md bg-white"
            @click.stop>
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                    <Eye class="h-5 w-5 mr-2 text-blue-600" />
                    Détails de la sanction
                </h3>
                <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <X class="h-6 w-6" />
                </button>
            </div>

            <div class="mt-4 space-y-6">
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-3">Informations de l'apprenant</h4>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nom</label>
                                <p class="text-sm text-gray-900">{{ sanction.learner }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Classe</label>
                                <p class="text-sm text-gray-900">{{ sanction.class }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-3">Détails de la sanction</h4>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Type</label>
                                <span :class="[
                                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                                    getSanctionTypeColor(sanction.sanctionType)
                                ]">
                                    {{ sanction.sanctionType }}
                                </span>
                            </div>
                            <div v-if="sanction.status">
                                <label class="block text-sm font-medium text-gray-500">Statut</label>
                                <span :class="[
                                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                                    getStatusColor(sanction.status)
                                ]">
                                    {{ getStatusLabel(sanction.status) }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Motif</label>
                            <p class="text-sm text-gray-900">{{ sanction.reason }}</p>
                        </div>
                        <div v-if="sanction.rule">
                            <label class="block text-sm font-medium text-gray-500">Règle appliquée</label>
                            <p class="text-sm text-gray-900">{{ sanction.rule }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-3">Chronologie</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="space-y-3">
                            <div v-if="sanction.calculatedOn" class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <Calculator class="h-4 w-4 text-blue-600" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">
                                        <strong>Calculée le {{ formatDate(sanction.calculatedOn) }}</strong>
                                    </p>
                                    <p class="text-xs text-gray-500">Sanction automatiquement déterminée</p>
                                </div>
                            </div>

                            <div v-if="sanction.appliedOn" class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <CheckCircle class="h-4 w-4 text-green-600" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">
                                        <strong>Appliquée le {{ formatDate(sanction.appliedOn) }}</strong>
                                    </p>
                                    <p class="text-xs text-gray-500">Par {{ sanction.appliedBy }}</p>
                                </div>
                            </div>

                            <div v-if="sanction.endDate && sanction.status === 'Active'" class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                    <Calendar class="h-4 w-4 text-orange-600" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">
                                        <strong>Fin prévue le {{ formatDate(sanction.endDate) }}</strong>
                                    </p>
                                    <p class="text-xs text-gray-500">Durée: {{ sanction.duration }} jour{{
                                        sanction.duration > 1 ? 's' : '' }}</p>
                                </div>
                            </div>

                            <div v-if="sanction.liftedOn" class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <Shield class="h-4 w-4 text-purple-600" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">
                                        <strong>Levée le {{ formatDate(sanction.liftedOn) }}</strong>
                                    </p>
                                    <p class="text-xs text-gray-500">Par {{ sanction.liftedBy }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-gray-200">
                <button @click="closeModal"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {
    Eye,
    X,
    Calculator,
    CheckCircle,
    Calendar,
    Shield
} from 'lucide-vue-next';

const props = defineProps({
    sanction: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['close']);

const closeModal = () => {
    emit('close');
};

const getSanctionTypeColor = (type) => {
    const colors = {
        'Avertissement': 'bg-yellow-100 text-yellow-800',
        'Blâme': 'bg-orange-100 text-orange-800',
        'Exclusion': 'bg-red-100 text-red-800'
    };
    return colors[type] || 'bg-gray-100 text-gray-800';
};

const getStatusColor = (status) => {
    const colors = {
        'Active': 'bg-green-100 text-green-800',
        'Expired': 'bg-gray-100 text-gray-800',
        'Lifted': 'bg-blue-100 text-blue-800'
    };
    return colors[status] || 'bg-gray-100 text-gray-800';
};

const getStatusLabel = (status) => {
    const labels = {
        'Active': 'Active',
        'Expired': 'Expirée',
        'Lifted': 'Levée'
    };
    return labels[status] || status;
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
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay, when the modal is open -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div
                class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-charcoal-900 flex items-center">
                            <Eye class="h-5 w-5 mr-2 text-teal-600" />
                            Détails de la sanction
                        </h3>
                        <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                    </div>

                    <div class="mt-3 text-center sm:mt-0 sm:text-left">
                        <div class="mt-2">
                            <!-- Sanction Details -->
                            <dl class="divide-y divide-gray-200">
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Type de sanction
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <span :class="getSanctionTypeColor(sanction.type)"
                                            class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium">
                                            {{ sanction.type }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Status
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <span :class="getStatusColor(sanction.status)"
                                            class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium">
                                            {{ sanction.status }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Motif
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ sanction.reason }}
                                    </dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Description
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ sanction.description }}
                                    </dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Remarques
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ sanction.notes }}
                                    </dd>
                                </div>
                            </dl>

                            <!-- Timeline section -->
                            <div class="mt-6">
                                <h4 class="text-md font-semibold text-gray-700 mb-3">Timeline</h4>
                                <div class="space-y-3">
                                    <div v-if="sanction.calculatedOn" class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-light-blue-100 rounded-full flex items-center justify-center">
                                            <Calculator class="h-4 w-4 text-teal-600" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Calculée le</div>
                                            <div class="text-sm text-gray-500">{{ formatDate(sanction.calculatedOn) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="sanction.appliedOn" class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                                            <CheckCircle class="h-4 w-4 text-teal-600" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Appliquée le</div>
                                            <div class="text-sm text-gray-500">{{ formatDate(sanction.appliedOn) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="sanction.endDate && sanction.status === 'Active'"
                                        class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-golden-yellow-100 rounded-full flex items-center justify-center">
                                            <Calendar class="h-4 w-4 text-golden-yellow" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Expire le</div>
                                            <div class="text-sm text-gray-500">{{ formatDate(sanction.endDate) }}</div>
                                        </div>
                                    </div>

                                    <div v-if="sanction.liftedOn" class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-light-blue-100 rounded-full flex items-center justify-center">
                                            <Shield class="h-4 w-4 text-light-blue-600" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Levée le</div>
                                            <div class="text-sm text-gray-500">{{ formatDate(sanction.liftedOn) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        @click="$emit('close')">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
// import { Eye, Calculator, CheckCircle, Calendar, Shield } from '@heroicons/vue/24/solid';
import { format } from 'date-fns';
import { fr } from 'date-fns/locale';
import {
    Eye,
    Calculator,
    CheckCircle,
    Calendar,
    Shield,
    X
} from 'lucide-vue-next';

export default defineComponent({
    components: {
        XMarkIcon,
        Eye,
        Calculator,
        CheckCircle,
        Calendar,
        Shield
    },
    props: {
        sanction: {
            type: Object,
            required: true
        }
    },
    setup() {
        const formatDate = (dateString) => {
            const date = new Date(dateString);
            return format(date, 'd MMMM yyyy', { locale: fr });
        };

        const getSanctionTypeColor = (type) => {
            const colors = {
                'Avertissement': 'bg-bright-yellow text-charcoal-900',
                'Blâme': 'bg-golden-yellow text-white',
                'Exclusion': 'bg-red-orange text-white'
            };
            return colors[type] || 'bg-gray-100 text-gray-800';
        };

        const getStatusColor = (status) => {
            const colors = {
                'Active': 'bg-teal-100 text-teal-800',
                'Expired': 'bg-gray-100 text-gray-800',
                'Lifted': 'bg-light-blue-100 text-light-blue-800'
            };
            return colors[status] || 'bg-gray-100 text-gray-800';
        };

        return {
            formatDate,
            getSanctionTypeColor,
            getStatusColor
        };
    }
});
</script>

<style scoped>
/* Brand Colors */
.text-charcoal-900 {
    color: #1E1E1E;
}

.text-teal-600 {
    color: #00B3C6;
}

.text-golden-yellow {
    color: #D99200;
}

.text-light-blue-600 {
    color: #9BB5D6;
}

.bg-light-blue-100 {
    background-color: #E8EDF5;
}

.bg-teal-100 {
    background-color: #CCF2F5;
}

.bg-golden-yellow-100 {
    background-color: #FFF4CC;
}

.bg-bright-yellow {
    background-color: #FFDD33;
}

.bg-golden-yellow {
    background-color: #D99200;
}

.bg-red-orange {
    background-color: #FF5F33;
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