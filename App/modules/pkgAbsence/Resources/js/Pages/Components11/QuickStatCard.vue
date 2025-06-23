<template>
  <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center">
      <div :class="[
        'w-10 h-10 rounded-lg flex items-center justify-center mr-3',
        getColorClasses(color).bg
      ]">
        <component :is="iconComponent" :class="['w-5 h-5', getColorClasses(color).text]" />
      </div>
      <div>
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">{{ label }}</p>
        <p class="text-xl font-bold text-gray-900">{{ value }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { 
  Calendar, 
  Check, 
  X, 
  Flag, 
  Users, 
  Clock 
} from 'lucide-vue-next'

const props = defineProps({
  label: String,
  value: [String, Number],
  icon: String,
  color: String
})

const iconComponents = {
  Calendar,
  Check,
  X,
  Flag,
  Users,
  Clock
}

const iconComponent = computed(() => iconComponents[props.icon] || Calendar)

function getColorClasses(color) {
  const colors = {
    red: { bg: 'bg-red-100', text: 'text-red-600' },
    green: { bg: 'bg-green-100', text: 'text-green-600' },
    blue: { bg: 'bg-blue-100', text: 'text-blue-600' },
    orange: { bg: 'bg-orange-100', text: 'text-orange-600' },
    purple: { bg: 'bg-purple-100', text: 'text-purple-600' },
    gray: { bg: 'bg-gray-100', text: 'text-gray-600' }
  }
  return colors[color] || colors.gray
}
</script>
