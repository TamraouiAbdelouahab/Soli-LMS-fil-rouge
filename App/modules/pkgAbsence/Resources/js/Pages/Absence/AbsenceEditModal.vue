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
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
              </div>
              <h3 class="text-base font-bold text-white">Modifier l'absence</h3>
            </div>
            <button @click="$emit('close')" 
                    class="text-white hover:text-gray-200 transition-all duration-200 p-1 rounded-lg hover:bg-white hover:bg-opacity-20">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Form Content -->
        <form @submit.prevent="handleSubmit" class="p-4 space-y-4">
          <!-- Student Info (Read-only) -->
          <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-lg p-3 border border-gray-100">
            <div class="flex items-center space-x-3">
              <div class="relative flex-shrink-0">
                <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-sm">
                  <span class="text-sm font-bold text-white">
                    {{ (formData.apprenant?.nom?.charAt(0) || '') + (formData.apprenant?.prenom?.charAt(0) || '') }}
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
                  {{ formData.apprenant?.nom }} {{ formData.apprenant?.prenom }}
                </h4>
              </div>
            </div>
          </div>

          <!-- Apprenant Selection (if creating new) -->
          <div v-if="!absence" class="space-y-2">
            <label class="block text-xs font-medium text-gray-700">
              <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
              Apprenant
            </label>
            <select v-model="formData.apprenant_id" 
                    class="w-full text-xs border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
              <option value="">Sélectionner un apprenant</option>
              <option v-for="apprenant in apprenants" :key="apprenant.id" :value="apprenant.id">
                {{ apprenant.nom }} {{ apprenant.prenom }}
              </option>
            </select>
          </div>

          <!-- Session Selection -->
          <div class="space-y-2">
            <label class="block text-xs font-medium text-gray-700">
              <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              Séance
            </label>
            <select v-model="formData.seance_id" 
                    class="w-full text-xs border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
              <option value="">Sélectionner une séance</option>
              <option v-for="seance in seances" :key="seance.id" :value="seance.id">
                {{ formatDate(seance.date_debut) }} → {{ formatDate(seance.date_fin) }}
              </option>
            </select>
          </div>

          <!-- Status Fields -->
          <div class="space-y-3">
            <!-- Justified Status -->
            <div class="bg-white border rounded-lg p-3">
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                  <div :class="[
                    'rounded-md p-1.5',
                    formData.justifie ? 'bg-green-100' : 'bg-red-100'
                  ]">
                    <svg :class="[
                      'w-3 h-3',
                      formData.justifie ? 'text-green-600' : 'text-red-600'
                    ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path v-if="formData.justifie" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  </div>
                  <div class="flex-1">
                    <h6 class="text-xs font-semibold text-gray-900 mb-1">Justification</h6>
                    <label class="flex items-center space-x-2">
                      <input type="checkbox" 
                             v-model="formData.justifie"
                             class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                      <span class="text-xs text-gray-600">Absence justifiée</span>
                    </label>
                  </div>
                </div>
                <div :class="[
                  'text-lg font-bold',
                  formData.justifie ? 'text-green-600' : 'text-red-600'
                ]">
                  {{ formData.justifie ? '✓' : '✗' }}
                </div>
              </div>
            </div>

            <!-- Sanctioned Status -->
            <div class="bg-white border rounded-lg p-3">
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                  <div :class="[
                    'rounded-md p-1.5',
                    formData.est_sanctionnée ? 'bg-orange-100' : 'bg-gray-100'
                  ]">
                    <svg :class="[
                      'w-3 h-3',
                      formData.est_sanctionnée ? 'text-orange-600' : 'text-gray-600'
                    ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                  </div>
                  <div class="flex-1">
                    <h6 class="text-xs font-semibold text-gray-900 mb-1">Sanction</h6>
                    <label class="flex items-center space-x-2">
                      <input type="checkbox" 
                             v-model="formData.est_sanctionnée"
                             class="rounded border-gray-300 text-orange-600 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50">
                      <span class="text-xs text-gray-600">Absence sanctionnée</span>
                    </label>
                  </div>
                </div>
                <div :class="[
                  'text-lg font-bold',
                  formData.est_sanctionnée ? 'text-orange-600' : 'text-gray-400'
                ]">
                  {{ formData.est_sanctionnée ? '⚠' : '○' }}
                </div>
              </div>
            </div>
          </div>
        </form>

        <!-- Action Footer -->
        <div class="bg-gray-50 px-4 py-3 border-t border-gray-100">
          <div class="flex space-x-2">
            <button @click="$emit('close')" 
                    type="button"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
              Annuler
            </button>
            <button @click="handleSubmit" 
                    type="submit"
                    :disabled="isSubmitting"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
              <svg v-if="!isSubmitting" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
              <svg v-else class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ isSubmitting ? 'Enregistrement...' : 'Enregistrer' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, reactive, watch } from 'vue'

const props = defineProps({
  show: Boolean,
  absence: Object,
  apprenants: Array,
  seances: Array,
})

const emit = defineEmits(['close', 'submit'])

const isSubmitting = ref(false)

// Form data
const formData = reactive({
  apprenant_id: '',
  seance_id: '',
  justifie: false,
  est_sanctionnée: false,
  notes: '',
  apprenant: null,
  seance: null
})

// Watch for absence changes to populate form
watch(() => props.absence, (newAbsence) => {
  if (newAbsence) {
    // Editing existing absence
    formData.apprenant_id = newAbsence.apprenant_id || ''
    formData.seance_id = newAbsence.seance_id || ''
    formData.justifie = newAbsence.justifie || false
    formData.est_sanctionnée = newAbsence.est_sanctionnée || false
    formData.notes = newAbsence.notes || ''
    formData.apprenant = newAbsence.apprenant
    formData.seance = newAbsence.seance
  } else {
    // Creating new absence
    resetForm()
  }
}, { immediate: true })

// Watch for apprenant selection
watch(() => formData.apprenant_id, (newId) => {
  if (newId && props.apprenants) {
    formData.apprenant = props.apprenants.find(a => a.id == newId)
  }
})

// Watch for seance selection
watch(() => formData.seance_id, (newId) => {
  if (newId && props.seances) {
    formData.seance = props.seances.find(s => s.id == newId)
  }
})

function resetForm() {
  formData.apprenant_id = ''
  formData.seance_id = ''
  formData.justifie = false
  formData.est_sanctionnée = false
  formData.notes = ''
  formData.apprenant = null
  formData.seance = null
}

async function handleSubmit() {
  if (isSubmitting.value) return
  
  isSubmitting.value = true
  
  try {
    const submitData = {
      apprenant_id: formData.apprenant_id,
      seance_id: formData.seance_id,
      justifie: formData.justifie,
      est_sanctionnée: formData.est_sanctionnée,
      notes: formData.notes
    }
    
    emit('submit', submitData)
  } finally {
    isSubmitting.value = false
  }
}

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
