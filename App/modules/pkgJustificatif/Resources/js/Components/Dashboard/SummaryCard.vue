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
        <a class="flex items-center mt-2 justify-start gap-1 cursor-pointer" :href="href">
            <div>
                <p class="underline text-l text-center opacity-80">{{ "voir plus"  }}</p>
            </div>
            <div>
                <component :is="ArrowRightCircle" class="h-4 w-4"/>
            </div>
        </a>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import {
  Gavel,
  Calendar,
  Clock,
  AlertTriangle,
  Mail,
  Check,
  X,
  ArrowRightCircle
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
    href: {
        type: String,
        required: true
    }
});

const iconComponent = computed(() => {
    const icons = {
        'Gavel': Gavel,
        'Check': Check,
        'Clock': Clock,
        'Mail': Mail,
        'Calendar': Calendar,
        'AlertTriangle': AlertTriangle,
        'XCircle': X
    };
    return icons[props.icon] || Gavel;
});

const colorClasses = {
    blue: {
        bg: 'bg-blue-500',
        iconBg: 'bg-blue-400'
    },
    orange: {
        bg: 'bg-orange-500',
        iconBg: 'bg-orange-400'
    },
    yellow: {
        bg: 'bg-yellow-500',
        iconBg: 'bg-yellow-400'
    },
    green: {
        bg: 'bg-green-500',
        iconBg: 'bg-green-400'
    },
    red: {
        bg: 'bg-red-500',
        iconBg: 'bg-red-400'
    },
    teal: {
        bg: 'bg-red-500',
        iconBg: 'bg-red-400'
    },
};

const bgColor = computed(() => colorClasses[props.color]?.bg || 'bg-gray-500');
const iconBgColor = computed(() => colorClasses[props.color]?.iconBg || 'bg-gray-400');

</script>
