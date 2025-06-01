<template>
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Analyse des justifications</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div v-for="(item, key) in analyticsData" :key="key" class="flex items-center p-4 bg-white rounded-lg shadow">
                <div :class="[
                    'p-3 rounded-full text-white mr-4',
                    colorClass(item.color)
                ]">
                    <component :is="icons[item.icon]" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-sm text-gray-500 capitalize">{{ key }}</p>
                    <p class="text-xl font-semibold text-gray-800">{{ item.value }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps,ref,computed } from 'vue';
import { TrendingUp, Users, Clock, AlertCircle } from 'lucide-vue-next';

const props = defineProps({
    justifications: {
        type: Object,
        required: true
    }
});

const icons = {
    TrendingUp,
    Users,
    Clock,
    AlertCircle
};

const raisons = props.justifications.reduce((acc, justification) => {
    const raison = justification.raison.libelle;
    acc[raison] = (acc[raison] || 0) + 1;
    return acc;
}, {});
const raisontendance = computed(() =>{
    let max = 0;
    let raisonMax = null;
    for (let raison in raisons) {
    if (raisons[raison] > max) {
        max = raisons[raison];
        raisonMax = raison;
    }
}
    return raisonMax;
});

console.log(props.justifications);
const apprenants = [...new Set(props.justifications.apprenant)];
console.log(props.justifications.apprenant);








const analyticsData = ref({
    tendance: {
        value: raisontendance,
        icon: 'TrendingUp',
        color: 'red'
    },
    apprenants: {
        value: '12',
        icon: 'Users',
        color: 'orange'
    },
    duree: {
        value: '5 jours',
        icon: 'Clock',
        color: 'blue'
    },
    attente: {
        value: '7',
        icon: 'AlertCircle',
        color: 'red'
    }
});



// Return Tailwind background color classes based on prop value
const colorClass = (color) => {
    const colorMap = {
        red: 'bg-red-500',
        orange: 'bg-orange-500',
        blue: 'bg-blue-500',
        green: 'bg-green-500',
        yellow: 'bg-yellow-500',
        purple: 'bg-purple-500'
    };
    return colorMap[color] || 'bg-gray-400';
};
</script>
