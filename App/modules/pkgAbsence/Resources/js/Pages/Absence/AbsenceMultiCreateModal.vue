<template>
  <transition name="modal">
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-hidden transform">
        <!-- Header amélioré -->
        <div class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 px-8 py-6">
          <div class="absolute inset-0 bg-black bg-opacity-10"></div>
          <div class="relative flex items-center justify-between">
            <div class="flex items-center space-x-4">
              <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-3 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
              </div>
              <div>
                <h3 class="text-xl font-bold text-white">Absences Groupées</h3>
                <p class="text-blue-100 text-sm mt-1">Enregistrez plusieurs absences simultanément</p>
              </div>
            </div>
            <button 
              @click="handleClose" 
              class="text-white hover:text-blue-100 transition-all duration-200 p-2 rounded-xl hover:bg-white hover:bg-opacity-20 group"
              title="Fermer"
            >
              <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Contenu principal -->
        <div class="max-h-[calc(90vh-200px)] overflow-y-auto">
          <form @submit.prevent="handleSubmit" class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <!-- Colonne gauche: Configuration -->
              <div class="space-y-6">
                <!-- Sélection de séance -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border-2 border-blue-200">
                  <label class="block text-sm font-semibold text-gray-700 mb-4">
                    <div class="flex items-center space-x-2">
                      <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                      <span>Séance *</span>
                    </div>
                  </label>
                  <select 
                    v-model="formData.seance_id" 
                    required 
                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200"
                    @change="onSeanceChange"
                  >
                    <option value="">Sélectionner une séance</option>
                    <option v-for="seance in seances" :key="seance.id" :value="seance.id">
                      {{ formatSessionDisplay(seance) }}
                    </option>
                  </select>
                </div>

                <!-- Options d'absence -->
                <div class="space-y-4">
                  <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Options d'absence
                  </h4>

                  <!-- Carte Justification -->
                  <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg">
                    <label class="flex items-center cursor-pointer group">
                      <input 
                        v-model="formData.justifie" 
                        type="checkbox" 
                        class="w-5 h-5 text-green-600 border-2 border-gray-300 rounded focus:ring-green-500 transition-all duration-200"
                      />
                      <div class="ml-4 flex-1">
                        <div class="flex items-center space-x-3">
                          <div :class="[
                            'rounded-xl p-3 transition-all duration-300',
                            formData.justifie ? 'bg-green-500 shadow-lg' : 'bg-gray-300'
                          ]">
                            <svg :class="[
                              'w-6 h-6 transition-all duration-300',
                              formData.justifie ? 'text-white' : 'text-gray-500'
                            ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                          </div>
                          <div>
                            <div class="font-semibold text-gray-900 group-hover:text-green-700 transition-colors duration-200">
                              Absence justifiée
                            </div>
                            <div class="text-sm text-gray-600">
                              Marquer toutes ces absences comme justifiées
                            </div>
                          </div>
                        </div>
                      </div>
                      <div :class="[
                        'text-3xl font-bold transition-all duration-300',
                        formData.justifie ? 'text-green-600 scale-110' : 'text-gray-400'
                      ]">
                        {{ formData.justifie ? '✓' : '○' }}
                      </div>
                    </label>
                  </div>

                  <!-- Carte Sanction -->
                  <div class="bg-gradient-to-br from-orange-50 to-amber-50 border-2 border-orange-200 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg">
                    <label class="flex items-center cursor-pointer group">
                      <input 
                        v-model="formData.est_sanctionnée" 
                        type="checkbox" 
                        class="w-5 h-5 text-orange-600 border-2 border-gray-300 rounded focus:ring-orange-500 transition-all duration-200"
                      />
                      <div class="ml-4 flex-1">
                        <div class="flex items-center space-x-3">
                          <div :class="[
                            'rounded-xl p-3 transition-all duration-300',
                            formData.est_sanctionnée ? 'bg-orange-500 shadow-lg' : 'bg-gray-300'
                          ]">
                            <svg :class="[
                              'w-6 h-6 transition-all duration-300',
                              formData.est_sanctionnée ? 'text-white' : 'text-gray-500'
                            ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                          </div>
                          <div>
                            <div class="font-semibold text-gray-900 group-hover:text-orange-700 transition-colors duration-200">
                              Absence sanctionnée
                            </div>
                            <div class="text-sm text-gray-600">
                              Appliquer une sanction pour ces absences
                            </div>
                          </div>
                        </div>
                      </div>
                      <div :class="[
                        'text-3xl font-bold transition-all duration-300',
                        formData.est_sanctionnée ? 'text-orange-600 scale-110' : 'text-gray-400'
                      ]">
                        {{ formData.est_sanctionnée ? '⚠' : '○' }}
                      </div>
                    </label>
                  </div>
                </div>

                <!-- Résumé -->
                <transition
                  enter-active-class="transition duration-300 ease-out"
                  enter-from-class="transform scale-95 opacity-0"
                  enter-to-class="transform scale-100 opacity-100"
                  leave-active-class="transition duration-200 ease-in"
                  leave-from-class="transform scale-100 opacity-100"
                  leave-to-class="transform scale-95 opacity-0"
                >
                  <div v-if="formData.apprenant_ids.length > 0" class="bg-gradient-to-br from-indigo-50 to-purple-50 border-2 border-indigo-200 rounded-2xl p-6">
                    <div class="flex items-center mb-4">
                      <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                      </svg>
                      <span class="font-semibold text-indigo-900 text-lg">Résumé</span>
                    </div>
                    <div class="space-y-3 text-sm">
                      <div class="flex justify-between items-center">
                        <span class="text-gray-600">Apprenants sélectionnés :</span>
                        <span class="font-bold text-indigo-900 text-lg">{{ formData.apprenant_ids.length }}</span>
                      </div>
                      <div v-if="selectedSeance" class="flex justify-between items-center">
                        <span class="text-gray-600">Séance :</span>
                        <span class="font-medium text-gray-900">{{ formatSessionDisplay(selectedSeance) }}</span>
                      </div>
                      <div class="flex justify-between items-center">
                        <span class="text-gray-600">Statut :</span>
                        <div class="flex space-x-2">
                          <span v-if="formData.justifie" class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                            Justifiée
                          </span>
                          <span v-if="formData.est_sanctionnée" class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-medium">
                            Sanctionnée
                          </span>
                          <span v-if="!formData.justifie && !formData.est_sanctionnée" class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                            Standard
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </transition>
              </div>

              <!-- Colonne droite: Sélection des apprenants -->
              <div class="space-y-6">
                <!-- En-tête avec compteur -->
                <div class="flex items-center justify-between">
                  <label class="block text-lg font-semibold text-gray-700">
                    <div class="flex items-center space-x-2">
                      <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                      </svg>
                      <span>Apprenants *</span>
                    </div>
                  </label>
                  <div class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ formData.apprenant_ids.length }}/{{ filteredApprenants.length }} sélectionné{{ formData.apprenant_ids.length > 1 ? 's' : '' }}
                  </div>
                </div>

                <!-- Barre de recherche -->
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                  </div>
                  <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Rechercher un apprenant..."
                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200"
                  />
                  <div v-if="searchQuery" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                    <button @click="searchQuery = ''" class="text-gray-400 hover:text-gray-600">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                      </svg>
                    </button>
                  </div>
                </div>

                <!-- Actions rapides -->
                <div class="flex space-x-3">
                  <button
                    type="button"
                    @click="selectAll"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-indigo-100 text-indigo-700 rounded-xl hover:bg-indigo-200 transition-colors duration-200 font-medium"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Tout sélectionner
                  </button>
                  <button
                    type="button"
                    @click="deselectAll"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200 font-medium"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Tout désélectionner
                  </button>
                </div>

                <!-- Liste des apprenants -->
                <div class="border-2 border-gray-200 rounded-2xl overflow-hidden">
                  <div class="max-h-80 overflow-y-auto">
                    <div v-if="filteredApprenants.length === 0" class="p-12 text-center text-gray-500">
                      <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                      </svg>
                      <p class="text-lg font-medium text-gray-900 mb-2">Aucun apprenant trouvé</p>
                      <p class="text-gray-500">Essayez de modifier votre recherche</p>
                    </div>
                    
                    <div v-else class="divide-y divide-gray-200">
                      <label
                        v-for="apprenant in filteredApprenants"
                        :key="apprenant.id"
                        class="flex items-center p-4 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group"
                        :class="{ 'bg-indigo-50 border-l-4 border-indigo-500': formData.apprenant_ids.includes(apprenant.id) }"
                      >
                        <input
                          type="checkbox"
                          :value="apprenant.id"
                          v-model="formData.apprenant_ids"
                          class="w-5 h-5 text-indigo-600 border-2 border-gray-300 rounded focus:ring-indigo-500 transition-all duration-200"
                        />
                        <div class="ml-4 flex-1">
                          <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-600 rounded-full flex items-center justify-center mr-4 shadow-lg">
                              <span class="text-white text-sm font-bold">
                                {{ getInitials(apprenant) }}
                              </span>
                            </div>
                            <div class="flex-1">
                              <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-700 transition-colors duration-200">
                                {{ apprenant.prenom }} {{ apprenant.nom }}
                              </div>
                              <div v-if="apprenant.email" class="text-xs text-gray-500">{{ apprenant.email }}</div>
                              <div v-if="apprenant.groupes?.length" class="text-xs text-indigo-600 mt-1">
                                {{ apprenant.groupes.map(g => g.nom).join(', ') }}
                              </div>
                            </div>
                          </div>
                        </div>
                        <div v-if="formData.apprenant_ids.includes(apprenant.id)" class="text-indigo-600">
                          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                          </svg>
                        </div>
                      </label>
                    </div>
                  </div>
                </div>

                <!-- Message de validation -->
                <transition
                  enter-active-class="transition duration-300 ease-out"
                  enter-from-class="transform scale-95 opacity-0"
                  enter-to-class="transform scale-100 opacity-100"
                  leave-active-class="transition duration-200 ease-in"
                  leave-from-class="transform scale-100 opacity-100"
                  leave-to-class="transform scale-95 opacity-0"
                >
                  <div v-if="showValidationError" class="bg-red-50 border-2 border-red-200 rounded-2xl p-4">
                    <div class="flex items-center">
                      <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                      <span class="text-sm font-medium text-red-800">Veuillez sélectionner au moins un apprenant</span>
                    </div>
                  </div>
                </transition>
              </div>
            </div>
          </form>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">
              <span v-if="formData.apprenant_ids.length > 0" class="font-medium">
                {{ formData.apprenant_ids.length }} absence{{ formData.apprenant_ids.length > 1 ? 's' : '' }} sera{{ formData.apprenant_ids.length > 1 ? 'ont' : '' }} créée{{ formData.apprenant_ids.length > 1 ? 's' : '' }}
              </span>
              <span v-else class="text-gray-400">
                Sélectionnez des apprenants pour continuer
              </span>
            </div>
            <div class="flex space-x-4">
              <button
                type="button"
                @click="handleClose"
                class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200"
              >
                Annuler
              </button>
              <button
                @click="handleSubmit"
                :disabled="formData.apprenant_ids.length === 0 || !formData.seance_id || isSubmitting"
                class="px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 border border-transparent rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 transform hover:scale-105"
              >
                <svg v-if="!isSubmitting" class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <svg v-else class="w-4 h-4 mr-2 inline animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ isSubmitting ? 'Création en cours...' : `Créer ${formData.apprenant_ids.length} absence${formData.apprenant_ids.length > 1 ? 's' : ''}` }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  apprenants: {
    type: Array,
    default: () => []
  },
  seances: {
    type: Array,
    default: () => []
  }
})

const emit = defineEmits(['close', 'submit'])

// État du formulaire
const isSubmitting = ref(false)
const formData = ref({
  seance_id: '',
  apprenant_ids: [],
  justifie: false,
  est_sanctionnée: false
})

const searchQuery = ref('')
const showValidationError = ref(false)

// Computed properties
const selectedSeance = computed(() => {
  return props.seances.find(s => s.id == formData.value.seance_id)
})

const filteredApprenants = computed(() => {
  if (!searchQuery.value.trim()) return props.apprenants || []
  
  const query = searchQuery.value.toLowerCase().trim()
  return (props.apprenants || []).filter(apprenant => {
    const fullName = `${apprenant.prenom || ''} ${apprenant.nom || ''}`.toLowerCase()
    const email = (apprenant.email || '').toLowerCase()
    return fullName.includes(query) || email.includes(query)
  })
})

// Watchers
watch(() => formData.value.apprenant_ids, () => {
  if (showValidationError.value && formData.value.apprenant_ids.length > 0) {
    showValidationError.value = false
  }
})

watch(() => props.show, (newShow) => {
  if (newShow) {
    resetForm()
  }
})

// Méthodes
function getInitials(apprenant) {
  if (!apprenant) return '??'
  const prenom = apprenant.prenom?.charAt(0) || ''
  const nom = apprenant.nom?.charAt(0) || ''
  return (prenom + nom).toUpperCase()
}

function formatSessionDisplay(seance) {
  if (!seance) return 'N/A'
  return `${formatTime(seance.date_debut)} → ${formatTime(seance.date_fin)}`
}

function formatTime(heure) {
  if (!heure) return 'N/A'
  try {
    return new Date(`1970-01-01T${heure}Z`).toLocaleTimeString([], {
      hour: '2-digit',
      minute: '2-digit',
      hour12: false
    })
  } catch {
    return heure
  }
}

function selectAll() {
  formData.value.apprenant_ids = filteredApprenants.value.map(a => a.id)
}

function deselectAll() {
  formData.value.apprenant_ids = []
}

function onSeanceChange() {
  showValidationError.value = false
}

function resetForm() {
  formData.value = {
    seance_id: '',
    apprenant_ids: [],
    justifie: false,
    est_sanctionnée: false
  }
  searchQuery.value = ''
  showValidationError.value = false
  isSubmitting.value = false
}

function handleClose() {
  resetForm()
  emit('close')
}

async function handleSubmit() {
  if (isSubmitting.value) return

  // Validation
  if (formData.value.apprenant_ids.length === 0) {
    showValidationError.value = true
    return
  }

  if (!formData.value.seance_id) {
    alert('Veuillez sélectionner une séance.')
    return
  }

  isSubmitting.value = true

  try {
    // Créer un tableau d'absences individuelles
    // C'est ici la correction principale !
    const absences = formData.value.apprenant_ids.map(apprenant_id => ({
      apprenant_id: Number(apprenant_id),
      seance_id: Number(formData.value.seance_id),
      justifie: Boolean(formData.value.justifie),
      est_sanctionnée: Boolean(formData.value.est_sanctionnée),
      // Le user_id sera ajouté dans le composant parent
    }))

    // Émettre les données formatées correctement
    emit('submit', {
      absences: absences,
      metadata: {
        selectedSeance: selectedSeance.value,
        selectedApprenants: props.apprenants.filter(a => formData.value.apprenant_ids.includes(a.id)),
        count: absences.length
      }
    })

    resetForm()
  } catch (error) {
    console.error('Erreur lors de la soumission:', error)
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped>
.modal-enter-active {
  transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.modal-leave-active {
  transition: all 0.3s ease-in;
}

.modal-enter-from {
  opacity: 0;
  transform: scale(0.8) translateY(-20px);
}

.modal-leave-to {
  opacity: 0;
  transform: scale(0.9) translateY(-10px);
}

/* Scrollbar personnalisée */
.overflow-y-auto::-webkit-scrollbar {
  width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>
