<template>
  <transition name="modal">
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-3 sm:p-4">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform">
        <!-- Header -->
        <div class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-700 px-6 py-4">
          <div class="absolute inset-0 bg-black bg-opacity-10"></div>
          <div class="relative flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-2">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
              </div>
              <h3 class="text-lg font-bold text-white">
                {{ absence ? 'Modifier l\'absence' : 'Nouvelle Absence' }}
              </h3>
            </div>
            <button @click="handleClose" 
                    class="text-white hover:text-gray-200 transition-all duration-200 p-2 rounded-lg hover:bg-white hover:bg-opacity-20">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Form Content -->
        <form @submit.prevent="handleSubmit" class="p-6 space-y-6">
          <!-- Debug Info -->
          <div v-if="debugMode" class="bg-blue-50 border border-blue-200 rounded p-3 text-xs">
            <strong>Debug Info:</strong><br>
            Form Valid: {{ isFormValid }}<br>
            Submitting: {{ isSubmitting }}<br>
            Apprenant ID: {{ formData.apprenant_id }}<br>
            Séance ID: {{ formData.seance_id }}<br>
            Errors: {{ errors.length }}
          </div>

          <!-- Apprenant Selection -->
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">
              <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
              Apprenant *
            </label>
            <select v-model="formData.apprenant_id" 
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
              <option value="">Sélectionner un apprenant</option>
              <option v-for="apprenant in apprenants" :key="apprenant.id" :value="apprenant.id">
                {{ apprenant.nom }} {{ apprenant.prenom }}
                <span v-if="apprenant.groupes?.length" class="text-gray-500">
                  ({{ apprenant.groupes.map(g => g.nom).join(', ') }})
                </span>
              </option>
            </select>
          </div>

          <!-- Séance Selection -->
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">
              <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              Séance *
            </label>
            <select v-model="formData.seance_id" 
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
              <option value="">Sélectionner une séance</option>
              <option v-for="seance in seances" :key="seance.id" :value="seance.id">
                {{ formatDate(seance.date_debut) }} → {{ formatDate(seance.date_fin) }}
              </option>
            </select>
          </div>

          <!-- Status Fields -->
          <div class="space-y-4">
            <!-- Justified Status -->
            <div class="bg-gray-50 border rounded-lg p-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <div :class="[
                    'rounded-lg p-2',
                    formData.justifie ? 'bg-green-100' : 'bg-red-100'
                  ]">
                    <svg :class="[
                      'w-5 h-5',
                      formData.justifie ? 'text-green-600' : 'text-red-600'
                    ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path v-if="formData.justifie" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  </div>
                  <div class="flex-1">
                    <h6 class="text-sm font-semibold text-gray-900 mb-1">Justification</h6>
                    <label class="flex items-center space-x-2 cursor-pointer">
                      <input type="checkbox" 
                             v-model="formData.justifie"
                             class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                      <span class="text-sm text-gray-600">Cette absence est justifiée</span>
                    </label>
                  </div>
                </div>
                <div :class="[
                  'text-2xl font-bold',
                  formData.justifie ? 'text-green-600' : 'text-red-600'
                ]">
                  {{ formData.justifie ? '✓' : '✗' }}
                </div>
              </div>
            </div>

            <!-- Sanctioned Status -->
            <div class="bg-gray-50 border rounded-lg p-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <div :class="[
                    'rounded-lg p-2',
                    formData.est_sanctionnée ? 'bg-orange-100' : 'bg-gray-100'
                  ]">
                    <svg :class="[
                      'w-5 h-5',
                      formData.est_sanctionnée ? 'text-orange-600' : 'text-gray-600'
                    ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                  </div>
                  <div class="flex-1">
                    <h6 class="text-sm font-semibold text-gray-900 mb-1">Sanction</h6>
                    <label class="flex items-center space-x-2 cursor-pointer">
                      <input type="checkbox" 
                             v-model="formData.est_sanctionnée"
                             class="rounded border-gray-300 text-orange-600 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50">
                      <span class="text-sm text-gray-600">Cette absence est sanctionnée</span>
                    </label>
                  </div>
                </div>
                <div :class="[
                  'text-2xl font-bold',
                  formData.est_sanctionnée ? 'text-orange-600' : 'text-gray-400'
                ]">
                  {{ formData.est_sanctionnée ? '⚠' : '○' }}
                </div>
              </div>
            </div>
          </div>

          <!-- Sanctions (si disponibles) -->
          <div v-if="formData.est_sanctionnée && sanctions?.length" class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">
              <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
              </svg>
              Type de sanction
            </label>
            <select v-model="formData.sanction_absence_id" 
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500">
              <option value="">Aucune sanction spécifique</option>
              <option v-for="sanction in sanctions" :key="sanction.id" :value="sanction.id">
                {{ sanction.nom }} - {{ sanction.description }}
              </option>
            </select>
          </div>

          <!-- Validation Errors -->
          <div v-if="errors.length" class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
              <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Erreurs de validation</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                  <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
              </div>
            </div>
          </div>
        </form>

        <!-- Action Footer -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
          <div class="flex space-x-3">
            <button @click="handleClose" 
                    type="button"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
              Annuler
            </button>
            <button @click="handleSubmit" 
                    type="submit"
                    :disabled="isSubmitting || !isFormValid"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
              <svg v-if="!isSubmitting" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
              <svg v-else class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ isSubmitting ? 'Enregistrement...' : (absence ? 'Modifier' : 'Ajouter') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, reactive, computed, watch } from 'vue'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  absence: Object,
  apprenants: Array,
  seances: Array,
  sanctions: Array,
})

const emit = defineEmits(['close', 'submit'])

const isSubmitting = ref(false)
const errors = ref([])
const debugMode = ref(true) // Activer pour debug, désactiver en production

// Form data avec valeurs par défaut correctes
const formData = reactive({
  apprenant_id: '',
  seance_id: '',
  justifie: false,
  est_sanctionnée: false,
  sanction_absence_id: null,
})

// Form validation améliorée
const isFormValid = computed(() => {
  const hasApprenant = formData.apprenant_id && formData.apprenant_id !== ''
  const hasSeance = formData.seance_id && formData.seance_id !== ''
  return hasApprenant && hasSeance
})

// Watch for absence changes to populate form (for editing)
watch(() => props.absence, (newAbsence) => {
  console.log('👀 Watching absence change:', newAbsence)
  if (newAbsence) {
    // Editing existing absence
    formData.apprenant_id = newAbsence.apprenant_id || ''
    formData.seance_id = newAbsence.seance_id || ''
    formData.justifie = Boolean(newAbsence.justifie)
    formData.est_sanctionnée = Boolean(newAbsence.est_sanctionnée)
    formData.sanction_absence_id = newAbsence.sanction_absence_id || null
  } else {
    // Creating new absence
    resetForm()
  }
}, { immediate: true })

// Watch for modal show/hide to reset form
watch(() => props.show, (newShow) => {
  console.log('👀 Modal show changed:', newShow)
  if (newShow && !props.absence) {
    resetForm()
    errors.value = []
  }
})

// Reset sanction when est_sanctionnée is unchecked
watch(() => formData.est_sanctionnée, (newValue) => {
  if (!newValue) {
    formData.sanction_absence_id = null
  }
})

function resetForm() {
  console.log('🔄 Resetting form')
  formData.apprenant_id = ''
  formData.seance_id = ''
  formData.justifie = false
  formData.est_sanctionnée = false
  formData.sanction_absence_id = null
}

function validateForm() {
  errors.value = []
  
  if (!formData.apprenant_id || formData.apprenant_id === '') {
    errors.value.push('Veuillez sélectionner un apprenant')
  }
  
  if (!formData.seance_id || formData.seance_id === '') {
    errors.value.push('Veuillez sélectionner une séance')
  }
  
  // Validation des types
  if (formData.apprenant_id && isNaN(Number(formData.apprenant_id))) {
    errors.value.push('ID apprenant invalide')
  }
  
  if (formData.seance_id && isNaN(Number(formData.seance_id))) {
    errors.value.push('ID séance invalide')
  }
  
  console.log('✅ Form validation result:', errors.value.length === 0, errors.value)
  return errors.value.length === 0
}

function handleClose() {
  console.log('🚪 Handling close')
  emit('close')
}

async function handleSubmit() {
  console.log('📝 Handle submit called')
  console.log('📋 Form data:', JSON.stringify(formData, null, 2))
  
  if (isSubmitting.value) {
    console.log('⏳ Already submitting, ignoring')
    return
  }
  
  if (!validateForm()) {
    console.log('❌ Form validation failed')
    return
  }
  
  isSubmitting.value = true
  
  try {
    // Préparer les données avec conversion de types appropriée
    const submitData = {
      apprenant_id: Number(formData.apprenant_id),
      seance_id: Number(formData.seance_id),
      justifie: Boolean(formData.justifie),
      est_sanctionnée: Boolean(formData.est_sanctionnée),
      sanction_absence_id: formData.sanction_absence_id ? Number(formData.sanction_absence_id) : null,
    }
    
    console.log('📤 Submitting processed data:', submitData)
    emit('submit', submitData)
    
  } catch (error) {
    console.error('💥 Exception in handleSubmit:', error)
    errors.value = ['Une erreur est survenue lors de l\'enregistrement']
  } finally {
    isSubmitting.value = false
  }
}

function formatDate(heure) {
  if (!heure) return 'N/A'
  try {
    return new Date(`1970-01-01T${heure}Z`).toLocaleTimeString([], {
      hour: '2-digit',
      minute: '2-digit',
      hour12: false
    });
  } catch (error) {
    console.error('Date formatting error:', error)
    return heure
  }
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
