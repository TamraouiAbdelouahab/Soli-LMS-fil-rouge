<template>
    <div :class="[bgColor, 'rounded-lg shadow p-4 text-white']">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80">{{ title }}</p>
                <p class="text-2xl font-bold">{{ value }}</p>
            </div>
            <div :class="[iconBgColor, 'p-3 rounded-full']">
                <component :is="iconComponent" class="h-6 w-6" />
            </div>
        </div>
        <p class="text-xs mt-2 opacity-80">
            <button v-if="clickable" @click="$emit('view-details')"
                class="underline hover:text-gray-300 cursor-pointer p-0 m-0 bg-transparent border-0" type="button">{{
                    trend }}</button>
            <span v-else>{{ trend }}</span>
        </p>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import {
    Gavel,
    Calendar,
    AlertTriangle,
    Users,
} from 'lucide-vue-next';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    value: {
        type: [String, Number],
        required: true
    },
    trend: {
        type: String,
        default: ''
    },
    color: {
        type: String,
        default: 'blue'
    },
    icon: {
        type: String,
        required: true
    },
    clickable: {
        type: Boolean,
        default: false
    }
});

const iconComponent = computed(() => {
    const icons = {
        'Gavel': Gavel,
        'Calendar': Calendar,
        'AlertTriangle': AlertTriangle,
        'Users': Users
    };
    return icons[props.icon] || Gavel;
});

const colorClasses = {
    teal: {
        bg: 'bg-teal-500',
        iconBg: 'bg-teal-400'
    },
    orange: {
        bg: 'bg-orange-500',
        iconBg: 'bg-orange-400'
    },
    red: {
        bg: 'bg-red-500',
        iconBg: 'bg-red-400'
    },
    blue: {
        bg: 'bg-light-blue-600',
        iconBg: 'bg-light-blue-400'
    }
};

const bgColor = computed(() => colorClasses[props.color]?.bg || 'bg-gray-500');
const iconBgColor = computed(() => colorClasses[props.color]?.iconBg || 'bg-gray-400');

</script>