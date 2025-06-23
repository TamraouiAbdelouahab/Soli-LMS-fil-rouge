<template>
    <div :class="['bg-white rounded-lg shadow p-4 flex items-center', colorClass]">
        <div :class="['flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center', iconBgClass]">
            <UserXIcon v-if="icon === 'UserX'" :class="['w-5 h-5', iconColorClass]" />
            <UsersIcon v-else-if="icon === 'Users'" :class="['w-5 h-5', iconColorClass]" />
            <TrendingUpIcon v-else-if="icon === 'TrendingUp'" :class="['w-5 h-5', iconColorClass]" />
            <CheckCircleIcon v-else-if="icon === 'CheckCircle'" :class="['w-5 h-5', iconColorClass]" />
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">{{ title }}</p>
            <p class="text-2xl font-semibold text-gray-900">{{ value }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ trend }}</p>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { UserXIcon, UsersIcon, TrendingUpIcon, CheckCircleIcon } from 'lucide-vue-next'; // Assuming lucide-vue-next for icons

const props = defineProps({
    title: String,
    value: [String, Number],
    trend: String,
    color: String,
    icon: String,
});

const colorClass = computed(() => {
    switch (props.color) {
        case 'red': return 'border-l-4 border-red-500';
        case 'orange': return 'border-l-4 border-orange-500';
        case 'yellow': return 'border-l-4 border-yellow-500';
        case 'blue': return 'border-l-4 border-blue-500';
        default: return '';
    }
});

const iconBgClass = computed(() => {
    switch (props.color) {
        case 'red': return 'bg-red-100';
        case 'orange': return 'bg-orange-100';
        case 'yellow': return 'bg-yellow-100';
        case 'blue': return 'bg-blue-100';
        default: return 'bg-gray-100';
    }
});

const iconColorClass = computed(() => {
    switch (props.color) {
        case 'red': return 'text-red-600';
        case 'orange': return 'text-orange-600';
        case 'yellow': return 'text-yellow-600';
        case 'blue': return 'text-blue-600';
        default: return 'text-gray-600';
    }
});
</script>
