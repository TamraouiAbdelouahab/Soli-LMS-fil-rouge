<template>
  <div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center">
      <div class="flex-shrink-0">
        <component :is="iconComponent" :class="[iconColor, 'h-8 w-8']" />
      </div>
      <div class="ml-4">
        <p class="text-sm font-medium text-gray-500">{{ title }}</p>
        <p :class="[textSize, 'font-bold text-gray-900']">{{ value }}</p>
      </div>
    </div>
  </div>
</template>


<script setup>
import { computed } from 'vue';
import {
  FileText,
  CheckCircle,
  Clock,
  Users
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
  color: {
    type: String,
    default: 'blue'
  },
  icon: {
    type: String,
    required: true
  },
  textSize: {
    type: String,
    default: 'text-base'
  }
});

const iconComponent = computed(() => {
  const icons = {
    'FileText': FileText,
    'CheckCircle': CheckCircle,
    'Clock': Clock,
    'Users': Users
  };
  return icons[props.icon] || FileText;
});

const colorClasses = {
  blue: {
    icon: 'text-blue-600',
  },
  orange: {
    icon: 'text-orange-600',
  },
  green: {
    icon: 'text-green-600',
  },
  purple: {
    icon: 'text-purple-600',
  }
};

const iconColor = computed(() => colorClasses[props.color]?.icon || 'text-gray-400');

</script>