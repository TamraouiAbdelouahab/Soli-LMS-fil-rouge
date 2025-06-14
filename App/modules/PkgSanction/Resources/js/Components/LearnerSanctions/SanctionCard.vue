<template>
    <div
        class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-200 hover:shadow-lg border border-gray-100">
        <!-- Card Header with Sanction Type -->
        <div :class="[
            'px-4 py-3 flex items-center justify-between',
            getHeaderColorClass(sanction.regle.sanction_type)
        ]">
            <div class="flex items-center">
                <div :class="[
                    'h-8 w-8 rounded-full flex items-center justify-center',
                    getIconBgClass(sanction.regle.sanction_type)
                ]">
                    <component :is="getSanctionIcon(sanction.regle.sanction_type)" class="h-4 w-4 text-white" />
                </div>
                <h3 class="ml-2 font-semibold text-white">{{ sanction.regle.sanction_type }}</h3>
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

        <!-- Card Body -->
        <div class="p-4">
            <!-- Dates -->
            <div class="mb-4 grid grid-cols-2 gap-2">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Date de début</p>
                    <p class="text-sm font-medium">{{ formatDate(sanction.date_debut) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Date de fin</p>
                    <p class="text-sm font-medium">{{ formatDate(sanction.date_fin) }}</p>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <p class="text-xs text-gray-500 mb-1">Description</p>
                <p class="text-sm text-gray-800">{{ sanction.regle.description }}</p>
            </div>

            <!-- Rule -->
            <div>
                <p class="text-xs text-gray-500 mb-1">Règle appliquée</p>
                <p class="text-sm font-medium text-gray-700">{{ sanction.regle.titre }}</p>
            </div>

            <!-- Duration Badge -->
            <div class="mt-4 flex items-center">
                <Clock class="h-4 w-4 text-gray-400 mr-1" />
                <span class="text-xs text-gray-500">
                    {{ getDurationText(sanction.date_debut, sanction.date_fin) }}
                </span>
            </div>
        </div>

        <!-- Card Footer -->
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
            <span class="text-xs text-gray-500">
                {{ isActive ? 'Se termine dans ' + getRemainingDays(sanction.date_fin) + ' jours' : 'Terminée' }}
            </span>
            <button @click="$emit('view', sanction)"
                class="text-teal-600 hover:text-teal-800 text-sm font-medium flex items-center">
                <Eye class="h-4 w-4 mr-1" />
                Voir
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { AlertTriangle, Clock, Eye, Ban, Clock3 } from 'lucide-vue-next';

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
    getHeaderColorClass: {
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

// Computed property to check if the sanction is active
const isActive = computed(() => {
    return new Date(props.sanction.date_fin) > new Date();
});

defineEmits(['view']);

</script>

<style scoped>
/* Brand Colors */
.bg-golden-yellow-dark {
    background-color: #B37700;
}

.bg-red-orange-dark {
    background-color: #E54A20;
}

.bg-orange-500 {
    background-color: #F97316;
}

.bg-orange-600 {
    background-color: #EA580C;
}
</style>