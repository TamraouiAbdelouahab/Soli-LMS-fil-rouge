<template>
  <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
    <div class="flex items-center justify-between">
      <div class="flex-1">
        <div class="flex items-center mb-2">
          <div :class="[
            'w-12 h-12 rounded-xl flex items-center justify-center mr-4',
            getColorClasses(color).bg
          ]">
            <component :is="iconComponent" :class="['w-6 h-6', getColorClasses(color).text]" />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600 mb-1">{{ title }}</p>
            <p class="text-3xl font-bold text-gray-900">{{ value }}</p>
          </div>
        </div>
        
        <div class="flex items-center mt-4">
          <div :class="[
            'flex items-center px-2 py-1 rounded-full text-xs font-medium',
            getTrendColor(trend)
          ]">
            <component :is="trendIcon" class="w-3 h-3 mr-1" />
            {{ Math.abs(trend) }}%
          </div>
          <span class="text-xs text-gray-500 ml-2">{{ description }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { 
  UserX, 
  Users, 
  CheckCircle, 
  AlertTriangle,
  TrendingUp,
  TrendingDown,
  Minus
} from 'lucide-vue-next'

const props = defineProps({
  title: String,
  value: [String, Number],
  previousValue: Number,
  icon: String,
  color: String,
  trend: [String, Number],
  description: String
})

const iconComponents = {
  UserX,
  Users,
  CheckCircle,
  AlertTriangle
}

const iconComponent = computed(() => iconComponents[props.icon] || Users)

const trendIcon = computed(() => {
  const trendValue = parseFloat(props.trend)
  if (trendValue > 0) return TrendingUp
  if (trendValue < 0) return TrendingDown
  return Minus
})

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

function getTrendColor(trend) {
  const trendValue = parseFloat(trend)
  if (trendValue > 0) return 'bg-green-100 text-green-800'
  if (trendValue < 0) return 'bg-red-100 text-red-800'
  return 'bg-gray-100 text-gray-800'
}
</script>
