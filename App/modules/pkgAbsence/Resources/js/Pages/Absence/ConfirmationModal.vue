<template>
  <transition name="modal">
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform">
        <!-- Header -->
        <div :class="[
          'px-6 py-4 border-b border-gray-200',
          type === 'danger' ? 'bg-red-50' : 'bg-gray-50'
        ]">
          <div class="flex items-center">
            <div :class="[
              'flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center',
              type === 'danger' ? 'bg-red-100' : 'bg-gray-100'
            ]">
              <svg v-if="type === 'danger'" class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
              </svg>
              <svg v-else class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-gray-900">{{ title }}</h3>
            </div>
          </div>
        </div>

        <!-- Content -->
        <div class="px-6 py-4">
          <p class="text-sm text-gray-600">{{ message }}</p>
        </div>

        <!-- Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
          <button
            @click="$emit('cancel')"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200"
          >
            {{ cancelText }}
          </button>
          <button
            @click="$emit('confirm')"
            :class="[
              'px-4 py-2 text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200',
              type === 'danger' 
                ? 'text-white bg-red-600 hover:bg-red-700 focus:ring-red-500'
                : 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500'
            ]"
          >
            {{ confirmText }}
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
defineProps({
  show: Boolean,
  title: String,
  message: String,
  confirmText: {
    type: String,
    default: 'Confirmer'
  },
  cancelText: {
    type: String,
    default: 'Annuler'
  },
  type: {
    type: String,
    default: 'default',
    validator: (value) => ['default', 'danger'].includes(value)
  }
})

defineEmits(['confirm', 'cancel'])
</script>

<style scoped>
.modal-enter-active {
  transition: all 0.3s ease-out;
}

.modal-leave-active {
  transition: all 0.3s ease-in;
}

.modal-enter-from {
  opacity: 0;
  transform: scale(0.9) translateY(-10px);
}

.modal-leave-to {
  opacity: 0;
  transform: scale(0.9) translateY(-10px);
}
</style>
