<template>
  <div class="text-center">
    <div class="relative w-24 h-24 mx-auto mb-4">
      <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 100 100">
        <!-- Background circle -->
        <circle
          cx="50"
          cy="50"
          r="40"
          stroke="#E5E7EB"
          stroke-width="8"
          fill="none"
        />
        <!-- Progress circle -->
        <circle
          cx="50"
          cy="50"
          r="40"
          :stroke="getColor(color)"
          stroke-width="8"
          fill="none"
          stroke-linecap="round"
          :stroke-dasharray="circumference"
          :stroke-dashoffset="strokeDashoffset"
          class="transition-all duration-1000 ease-out"
        />
      </svg>
      <div class="absolute inset-0 flex items-center justify-center">
        <span class="text-lg font-bold text-gray-900">{{ value }}{{ unit }}</span>
      </div>
    </div>
    <h3 class="font-semibold text-gray-900 mb-1">{{ title }}</h3>
    <p class="text-xs text-gray-500">{{ description }}</p>
    <div :class="[
      'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium mt-2',
      getStatusColor()
    ]">
      {{ getStatusText() }}
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  title: String,
  value: Number,
  unit: String,
  target: Number,
  color: String,
  description: String,
  inverse: Boolean // Pour les métriques où une valeur plus faible est meilleure
})

const circumference = 2 * Math.PI * 40

const progress = computed(() => {
  return Math.min((props.value / props.target) * 100, 100)
})

const strokeDashoffset = computed(() => {
  return circumference - (progress.value / 100) * circumference
})

function getColor(color) {
  const colors = {
    red: '#EF4444',
    green: '#10B981',
    blue: '#3B82F6',
    orange: '#F59E0B',
    purple: '#8B5CF6'
  }
  return colors[color] || colors.blue
}

function getStatusColor() {
  const isGood = props.inverse ? props.value <= props.target : props.value >= props.target
  return isGood 
    ? 'bg-green-100 text-green-800' 
    : 'bg-red-100 text-red-800'
}

function getStatusText() {
  const isGood = props.inverse ? props.value <= props.target : props.value >= props.target
  return isGood ? 'Objectif atteint' : 'À améliorer'
}
</script>
