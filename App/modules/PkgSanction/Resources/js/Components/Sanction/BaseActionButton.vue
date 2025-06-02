<template>
    <button :title="title" :class="[
        'flex items-center justify-center px-2 py-1 rounded-md text-xs font-medium transition',
        iconOnly ? 'w-8 h-8 p-0 justify-center' : 'space-x-1 px-3',
        colorClasses
    ]" @click="$emit('click')">
        <component :is="icon" class="h-4 w-4" />
        <span v-if="!iconOnly">{{ label }}</span>
    </button>
</template>

<script setup>
defineProps({
    icon: { type: Object, required: true },
    label: { type: String, default: '' },
    iconOnly: { type: Boolean, default: false },
    colorClasses: { type: String, default: 'bg-gray-100 text-gray-800 hover:bg-gray-200' },
    title: { type: String, default: '' }
});
defineEmits(['click']);
</script>
