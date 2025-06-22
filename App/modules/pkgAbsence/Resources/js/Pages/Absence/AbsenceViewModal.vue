<template>
  <transition name="modal">
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-3 sm:p-4">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm sm:max-w-md overflow-hidden transform">
        <!-- Compact Header -->
        <div class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-700 px-4 py-3">
          <div class="absolute inset-0 bg-black bg-opacity-10"></div>
          <div class="relative flex items-center justify-between">
            <div class="flex items-center space-x-2">
              <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-1.5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
              </div>
              <h3 class="text-base font-bold text-white">Détails de l'absence</h3>
            </div>
            <button @click="$emit('close')" 
                    class="text-white hover:text-gray-200 transition-all duration-200 p-1 rounded-lg hover:bg-white hover:bg-opacity-20">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Compact Content -->
        <div class="p-4 space-y-4">
          <!-- Student Info -->
          <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-lg p-3 border border-gray-100">
            <div class="flex items-center space-x-3">
              <div class="relative flex-shrink-0">
                <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-sm">
                  <span class="text-sm font-bold text-white">
                    {{ (absence.apprenant?.nom?.charAt(0) || '') + (absence.apprenant?.prenom?.charAt(0) || '') }}
                  </span>
                </div>
                <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-0.5 shadow-sm">
                  <svg class="w-2.5 h-2.5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                  </svg>
                </div>
              </div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-1 mb-1">
                  <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                  <span class="text-xs font-medium text-indigo-600 uppercase">Apprenant</span>
                </div>
                <h4 class="text-sm font-bold text-gray-900 truncate">
                  {{ absence.apprenant?.nom }} {{ absence.apprenant?.prenom }}
                </h4>
              </div>
            </div>
          </div>

          <!-- Session Info -->
          <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
            <div class="flex items-center space-x-2 mb-2">
              <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span class="text-xs font-medium text-blue-600 uppercase">Séance</span>
            </div>
            <div class="text-xs text-blue-900 font-medium">
                    {{ formatDate(absence.seance?.date_debut) }} → {{ formatDate(absence.seance?.date_fin) }}
            </div>
          </div>

          <!-- Compact Status Cards -->
          <div class="space-y-3">
            <!-- Justified Status -->
            <div class="bg-white border rounded-lg p-3">
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                  <div :class="[
                    'rounded-md p-1.5',
                    absence.justifie ? 'bg-green-100' : 'bg-red-100'
                  ]">
                    <svg :class="[
                      'w-3 h-3',
                      absence.justifie ? 'text-green-600' : 'text-red-600'
                    ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path v-if="absence.justifie" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  </div>
                  <div>
                    <h6 class="text-xs font-semibold text-gray-900">Justification</h6>
                    <span :class="[
                      'inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium',
                      absence.justifie 
                        ? 'bg-green-100 text-green-800' 
                        : 'bg-red-100 text-red-800'
                    ]">
                      {{ absence.justifie ? 'Justifiée' : 'Non justifiée' }}
                    </span>
                  </div>
                </div>
                <div :class="[
                  'text-lg font-bold',
                  absence.justifie ? 'text-green-600' : 'text-red-600'
                ]">
                  {{ absence.justifie ? '✓' : '✗' }}
                </div>
              </div>
            </div>

            <!-- Sanctioned Status -->
            <div class="bg-white border rounded-lg p-3">
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                  <div :class="[
                    'rounded-md p-1.5',
                    absence.est_sanctionnée ? 'bg-orange-100' : 'bg-gray-100'
                  ]">
                    <svg :class="[
                      'w-3 h-3',
                      absence.est_sanctionnée ? 'text-orange-600' : 'text-gray-600'
                    ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                  </div>
                  <div>
                    <h6 class="text-xs font-semibold text-gray-900">Sanction</h6>
                    <span :class="[
                      'inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium',
                      absence.est_sanctionnée 
                        ? 'bg-orange-100 text-orange-800' 
                        : 'bg-gray-100 text-gray-800'
                    ]">
                      {{ absence.est_sanctionnée ? 'Sanctionnée' : 'Non sanctionnée' }}
                    </span>
                  </div>
                </div>
                <div :class="[
                  'text-lg font-bold',
                  absence.est_sanctionnée ? 'text-orange-600' : 'text-gray-400'
                ]">
                  {{ absence.est_sanctionnée ? '⚠' : '○' }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Compact Footer -->
        <div class="bg-gray-50 px-4 py-3 border-t border-gray-100">
          <button @click="$emit('close')" 
                  class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Fermer
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
defineProps({
  show: Boolean,
  absence: Object,
});

const emit = defineEmits(['close']);

function formatDate(heure) {
  return new Date(`1970-01-01T${heure}Z`).toLocaleTimeString([], {
    hour: '2-digit',
    minute: '2-digit',
    hour12: false
  });
}
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
