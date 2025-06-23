<template>
  <transition name="modal">
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden transform">
        <!-- Header amélioré -->
        <div class="relative bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-700 px-8 py-6">
          <div class="absolute inset-0 bg-black bg-opacity-10"></div>
          <div class="relative flex items-center justify-between">
            <div class="flex items-center space-x-4">
              <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-3 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
              </div>
              <div>
                <h3 class="text-xl font-bold text-white">
                  {{ absence ? 'Modifier l\'absence' : 'Nouvelle Absence' }}
                </h3>
                <p class="text-emerald-100 text-sm mt-1">
                  {{ absence ? 'Modifiez les informations de cette absence' : 'Enregistrez une nouvelle absence d\'apprenant' }}
                </p>
              </div>
            </div>
            <button 
              @click="handleClose" 
              class="text-white hover:text-emerald-100 transition-all duration-200 p-2 rounded-xl hover:bg-white hover:bg-opacity-20 group"
              title="Fermer"
            >
              <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Contenu du formulaire avec scroll -->
        <div class="max-h-[calc(90vh-200px)] overflow-y-auto">
          <form @submit.prevent="handleSubmit" class="p-8 space-y-8">
            <!-- Indicateur de progression -->
            <div class="flex items-center justify-between mb-6">
              <div class="flex items-center space-x-2">
                <div :class="[
                  'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300',
                  formStep >= 1 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500'
                ]">
                  1
                </div>
                <div :class="[
                  'h-1 w-16 transition-all duration-300',
                  formStep >= 2 ? 'bg-emerald-500' : 'bg-gray-200'
                ]"></div>
                <div :class="[
                  'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300',
                  formStep >= 2 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500'
                ]">
                  2
                </div>
                <div :class="[
                  'h-1 w-16 transition-all duration-300',
                  formStep >= 3 ? 'bg-emerald-500' : 'bg-gray-200'
                ]"></div>
                <div :class="[
                  'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300',
                  formStep >= 3 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500'
                ]">
                  3
                </div>
              </div>
              <div class="text-sm text-gray-500">
                Étape {{ formStep }} sur 3
              </div>
            </div>

            <!-- Étape 1: Sélection Apprenant et Séance -->
            <div v-show="formStep === 1" class="space-y-6">
              <div class="text-center mb-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">Informations de base</h4>
                <p class="text-gray-600">Sélectionnez l'apprenant et la séance concernés</p>
              </div>

              <!-- Sélection Apprenant avec recherche -->
              <div class="space-y-3">
                <label class="block text-sm font-semibold text-gray-700">
                  <div class="flex items-center space-x-2 mb-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Apprenant *</span>
                  </div>
                </label>
                
                <!-- Recherche d'apprenant -->
                <div class="relative">
                  <input
                    v-model="apprenantSearch"
                    type="text"
                    placeholder="Rechercher un apprenant..."
                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-all duration-200"
                    @focus="showApprenantDropdown = true"
                  />
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                  </div>
                </div>

                <!-- Dropdown des apprenants -->
                <div v-if="showApprenantDropdown && filteredApprenants.length" class="relative">
                  <div class="absolute z-10 w-full bg-white border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-y-auto">
                    <div
                      v-for="apprenant in filteredApprenants"
                      :key="apprenant.id"
                      @click="selectApprenant(apprenant)"
                      class="flex items-center p-4 hover:bg-emerald-50 cursor-pointer transition-colors duration-150"
                    >
                      <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center">
                          <span class="text-sm font-bold text-white">
                            {{ getInitials(apprenant) }}
                          </span>
                        </div>
                      </div>
                      <div class="ml-3 flex-1">
                        <div class="text-sm font-medium text-gray-900">
                          {{ apprenant.nom }} {{ apprenant.prenom }}
                        </div>
                        <div v-if="apprenant.groupes?.length" class="text-xs text-gray-500">
                          {{ apprenant.groupes.map(g => g.nom).join(', ') }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Apprenant sélectionné -->
                <div v-if="selectedApprenant" class="bg-emerald-50 border-2 border-emerald-200 rounded-xl p-4">
                  <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                      <div class="h-12 w-12 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center">
                        <span class="text-sm font-bold text-white">
                          {{ getInitials(selectedApprenant) }}
                        </span>
                      </div>
                      <div>
                        <div class="text-sm font-semibold text-gray-900">
                          {{ selectedApprenant.nom }} {{ selectedApprenant.prenom }}
                        </div>
                        <div v-if="selectedApprenant.groupes?.length" class="text-xs text-emerald-600">
                          {{ selectedApprenant.groupes.map(g => g.nom).join(', ') }}
                        </div>
                      </div>
                    </div>
                    <button
                      @click="clearApprenant"
                      type="button"
                      class="text-emerald-600 hover:text-emerald-800 p-1 rounded-lg hover:bg-emerald-100 transition-colors duration-200"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>

              <!-- Sélection Séance -->
              <div class="space-y-3">
                <label class="block text-sm font-semibold text-gray-700">
                  <div class="flex items-center space-x-2 mb-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Séance *</span>
                  </div>
                </label>
                <select 
                  v-model="formData.seance_id" 
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-all duration-200"
                  required
                >
                  <option value="">Sélectionner une séance</option>
                  <option v-for="seance in seances" :key="seance.id" :value="seance.id">
                    {{ formatSessionDisplay(seance) }}
                  </option>
                </select>
              </div>
            </div>

            <!-- Étape 2: Statuts -->
            <div v-show="formStep === 2" class="space-y-6">
              <div class="text-center mb-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">Statut de l'absence</h4>
                <p class="text-gray-600">Définissez si l'absence est justifiée et/ou sanctionnée</p>
              </div>

              <!-- Carte Justification -->
              <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg">
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-4">
                    <div :class="[
                      'rounded-2xl p-4 transition-all duration-300',
                      formData.justifie ? 'bg-green-500 shadow-lg' : 'bg-gray-300'
                    ]">
                      <svg :class="[
                        'w-8 h-8 transition-all duration-300',
                        formData.justifie ? 'text-white' : 'text-gray-500'
                      ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path v-if="formData.justifie" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                    </div>
                    <div class="flex-1">
                      <h6 class="text-lg font-bold text-gray-900 mb-2">Justification</h6>
                      <label class="flex items-center space-x-3 cursor-pointer group">
                        <input 
                          type="checkbox" 
                          v-model="formData.justifie"
                          class="w-5 h-5 rounded border-2 border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200"
                        />
                        <span class="text-gray-700 group-hover:text-gray-900 transition-colors duration-200">
                          Cette absence est justifiée
                        </span>
                      </label>
                    </div>
                  </div>
                  <div :class="[
                    'text-4xl font-bold transition-all duration-300',
                    formData.justifie ? 'text-green-600 scale-110' : 'text-gray-400'
                  ]">
                    {{ formData.justifie ? '✓' : '✗' }}
                  </div>
                </div>
              </div>

              <!-- Carte Sanction -->
              <div class="bg-gradient-to-br from-orange-50 to-amber-50 border-2 border-orange-200 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg">
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-4">
                    <div :class="[
                      'rounded-2xl p-4 transition-all duration-300',
                      formData.est_sanctionnée ? 'bg-orange-500 shadow-lg' : 'bg-gray-300'
                    ]">
                      <svg :class="[
                        'w-8 h-8 transition-all duration-300',
                        formData.est_sanctionnée ? 'text-white' : 'text-gray-500'
                      ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                      </svg>
                    </div>
                    <div class="flex-1">
                      <h6 class="text-lg font-bold text-gray-900 mb-2">Sanction</h6>
                      <label class="flex items-center space-x-3 cursor-pointer group">
                        <input 
                          type="checkbox" 
                          v-model="formData.est_sanctionnée"
                          class="w-5 h-5 rounded border-2 border-gray-300 text-orange-600 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 transition-all duration-200"
                        />
                        <span class="text-gray-700 group-hover:text-gray-900 transition-colors duration-200">
                          Cette absence est sanctionnée
                        </span>
                      </label>
                    </div>
                  </div>
                  <div :class="[
                    'text-4xl font-bold transition-all duration-300',
                    formData.est_sanctionnée ? 'text-orange-600 scale-110' : 'text-gray-400'
                  ]">
                    {{ formData.est_sanctionnée ? '⚠' : '○' }}
                  </div>
                </div>
              </div>

              <!-- Type de sanction (conditionnel) -->
              <transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0"
              >
                <div v-if="formData.est_sanctionnée && sanctions?.length" class="space-y-3">
                  <label class="block text-sm font-semibold text-gray-700">
                    <div class="flex items-center space-x-2 mb-2">
                      <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                      </svg>
                      <span>Type de sanction</span>
                    </div>
                  </label>
                  <select 
                    v-model="formData.sanction_absence_id" 
                    class="w-full px-4 py-3 border-2 border-orange-200 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-200"
                  >
                    <option value="">Aucune sanction spécifique</option>
                    <option v-for="sanction in sanctions" :key="sanction.id" :value="sanction.id">
                      {{ sanction.nom }} - {{ sanction.description }}
                    </option>
                  </select>
                </div>
              </transition>
            </div>

            <!-- Étape 3: Notes et Confirmation -->
            <div v-show="formStep === 3" class="space-y-6">
              <div class="text-center mb-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">Notes et confirmation</h4>
                <p class="text-gray-600">Ajoutez des notes optionnelles et confirmez l'enregistrement</p>
              </div>

              <!-- Notes -->
              <div class="space-y-3">
                <label class="block text-sm font-semibold text-gray-700">
                  <div class="flex items-center space-x-2 mb-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <span>Notes (optionnel)</span>
                  </div>
                </label>
                <textarea 
                  v-model="formData.notes" 
                  rows="4"
                  placeholder="Ajoutez des notes sur cette absence (motif, contexte, etc.)..."
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:border-emerald-500 focus:ring-emerald-500 resize-none transition-all duration-200"
                ></textarea>
              </div>

              <!-- Résumé -->
              <div class="bg-gray-50 rounded-2xl p-6">
                <h5 class="text-lg font-semibold text-gray-900 mb-4">Résumé de l'absence</h5>
                <div class="space-y-3">
                  <div class="flex justify-between items-center">
                    <span class="text-gray-600">Apprenant :</span>
                    <span class="font-medium text-gray-900">
                      {{ selectedApprenant ? `${selectedApprenant.nom} ${selectedApprenant.prenom}` : 'Non sélectionné' }}
                    </span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-gray-600">Séance :</span>
                    <span class="font-medium text-gray-900">
                      {{ selectedSeance ? formatSessionDisplay(selectedSeance) : 'Non sélectionnée' }}
                    </span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-gray-600">Justifiée :</span>
                    <span :class="[
                      'px-3 py-1 rounded-full text-sm font-medium',
                      formData.justifie ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                    ]">
                      {{ formData.justifie ? 'Oui' : 'Non' }}
                    </span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-gray-600">Sanctionnée :</span>
                    <span :class="[
                      'px-3 py-1 rounded-full text-sm font-medium',
                      formData.est_sanctionnée ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800'
                    ]">
                      {{ formData.est_sanctionnée ? 'Oui' : 'Non' }}
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Messages d'erreur -->
            <transition
              enter-active-class="transition duration-300 ease-out"
              enter-from-class="transform scale-95 opacity-0"
              enter-to-class="transform scale-100 opacity-100"
              leave-active-class="transition duration-200 ease-in"
              leave-from-class="transform scale-100 opacity-100"
              leave-to-class="transform scale-95 opacity-0"
            >
              <div v-if="errors.length" class="bg-red-50 border-2 border-red-200 rounded-2xl p-6">
                <div class="flex items-start space-x-3">
                  <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  </div>
                  <div class="flex-1">
                    <h3 class="text-lg font-semibold text-red-800 mb-2">Erreurs de validation</h3>
                    <ul class="space-y-1">
                      <li v-for="error in errors" :key="error" class="text-red-700 flex items-center space-x-2">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span>{{ error }}</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </transition>
          </form>
        </div>

        <!-- Footer avec navigation -->
        <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <!-- Bouton Précédent -->
            <button
              v-if="formStep > 1"
              @click="previousStep"
              type="button"
              class="inline-flex items-center px-6 py-3 border-2 border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
              </svg>
              Précédent
            </button>
            <div v-else></div>

            <div class="flex space-x-3">
              <!-- Bouton Annuler -->
              <button 
                @click="handleClose" 
                type="button"
                class="inline-flex items-center px-6 py-3 border-2 border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Annuler
              </button>

              <!-- Bouton Suivant/Enregistrer -->
              <button 
                v-if="formStep < 3"
                @click="nextStep"
                type="button"
                :disabled="!canProceedToNextStep"
                class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105"
              >
                Suivant
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
              </button>

              <button 
                v-else
                @click="handleSubmit"
                type="submit"
                :disabled="isSubmitting || !isFormValid"
                class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105"
              >
                <svg v-if="!isSubmitting" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <svg v-else class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ isSubmitting ? 'Enregistrement...' : (absence ? 'Modifier' : 'Enregistrer') }}
              </button>
            </div>
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

// État du formulaire
const isSubmitting = ref(false)
const errors = ref([])
const formStep = ref(1)

// Recherche et sélection d'apprenant
const apprenantSearch = ref('')
const showApprenantDropdown = ref(false)
const selectedApprenant = ref(null)

// Données du formulaire
const formData = reactive({
  apprenant_id: '',
  seance_id: '',
  justifie: false,
  est_sanctionnée: false,
  sanction_absence_id: null,
  notes: ''
})

// Computed properties
const filteredApprenants = computed(() => {
  if (!apprenantSearch.value.trim()) return props.apprenants || []
  
  const search = apprenantSearch.value.toLowerCase().trim()
  return (props.apprenants || []).filter(apprenant => {
    const fullName = `${apprenant.nom} ${apprenant.prenom}`.toLowerCase()
    return fullName.includes(search)
  })
})

const selectedSeance = computed(() => {
  return (props.seances || []).find(s => s.id == formData.seance_id)
})

const isFormValid = computed(() => {
  return formData.apprenant_id && formData.seance_id
})

const canProceedToNextStep = computed(() => {
  switch (formStep.value) {
    case 1:
      return formData.apprenant_id && formData.seance_id
    case 2:
      return true // Pas de validation spécifique pour l'étape 2
    case 3:
      return isFormValid.value
    default:
      return false
  }
})

// Watchers
watch(() => props.absence, (newAbsence) => {
  if (newAbsence) {
    // Mode édition
    formData.apprenant_id = newAbsence.apprenant_id || ''
    formData.seance_id = newAbsence.seance_id || ''
    formData.justifie = Boolean(newAbsence.justifie)
    formData.est_sanctionnée = Boolean(newAbsence.est_sanctionnée)
    formData.sanction_absence_id = newAbsence.sanction_absence_id || null
    formData.notes = newAbsence.notes || ''
    
    // Définir l'apprenant sélectionné
    if (newAbsence.apprenant) {
      selectedApprenant.value = newAbsence.apprenant
      apprenantSearch.value = `${newAbsence.apprenant.nom} ${newAbsence.apprenant.prenom}`
    }
  } else {
    resetForm()
  }
}, { immediate: true })

watch(() => props.show, (newShow) => {
  if (newShow && !props.absence) {
    resetForm()
    errors.value = []
    formStep.value = 1
  }
  if (!newShow) {
    showApprenantDropdown.value = false
  }
})

watch(() => formData.est_sanctionnée, (newValue) => {
  if (!newValue) {
    formData.sanction_absence_id = null
  }
})

// Fermer le dropdown quand on clique ailleurs
watch(() => apprenantSearch.value, () => {
  if (apprenantSearch.value && !selectedApprenant.value) {
    showApprenantDropdown.value = true
  }
})

// Méthodes
function resetForm() {
  formData.apprenant_id = ''
  formData.seance_id = ''
  formData.justifie = false
  formData.est_sanctionnée = false
  formData.sanction_absence_id = null
  formData.notes = ''
  selectedApprenant.value = null
  apprenantSearch.value = ''
  showApprenantDropdown.value = false
}

function selectApprenant(apprenant) {
  selectedApprenant.value = apprenant
  formData.apprenant_id = apprenant.id
  apprenantSearch.value = `${apprenant.nom} ${apprenant.prenom}`
  showApprenantDropdown.value = false
}

function clearApprenant() {
  selectedApprenant.value = null
  formData.apprenant_id = ''
  apprenantSearch.value = ''
}

function getInitials(apprenant) {
  if (!apprenant) return '??'
  const nom = apprenant.nom?.charAt(0) || ''
  const prenom = apprenant.prenom?.charAt(0) || ''
  return (nom + prenom).toUpperCase()
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

function nextStep() {
  if (canProceedToNextStep.value && formStep.value < 3) {
    formStep.value++
  }
}

function previousStep() {
  if (formStep.value > 1) {
    formStep.value--
  }
}

function validateForm() {
  errors.value = []
  
  if (!formData.apprenant_id) {
    errors.value.push('Veuillez sélectionner un apprenant')
  }
  
  if (!formData.seance_id) {
    errors.value.push('Veuillez sélectionner une séance')
  }
  
  if (formData.apprenant_id && isNaN(Number(formData.apprenant_id))) {
    errors.value.push('ID apprenant invalide')
  }
  
  if (formData.seance_id && isNaN(Number(formData.seance_id))) {
    errors.value.push('ID séance invalide')
  }
  
  return errors.value.length === 0
}

function handleClose() {
  emit('close')
}

async function handleSubmit() {
  if (isSubmitting.value) return
  
  if (!validateForm()) return
  
  isSubmitting.value = true
  
  try {
    const submitData = {
      apprenant_id: Number(formData.apprenant_id),
      seance_id: Number(formData.seance_id),
      justifie: Boolean(formData.justifie),
      est_sanctionnée: Boolean(formData.est_sanctionnée),
      sanction_absence_id: formData.sanction_absence_id ? Number(formData.sanction_absence_id) : null,
      notes: formData.notes || null,
    }
    
    emit('submit', submitData)
    
  } catch (error) {
    console.error('Erreur lors de la soumission:', error)
    errors.value = ['Une erreur est survenue lors de l\'enregistrement']
  } finally {
    isSubmitting.value = false
  }
}

// Fermer le dropdown quand on clique ailleurs
document.addEventListener('click', (e) => {
  if (!e.target.closest('.relative')) {
    showApprenantDropdown.value = false
  }
})
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

/* Animation pour les étapes */
.step-enter-active,
.step-leave-active {
  transition: all 0.3s ease;
}

.step-enter-from {
  opacity: 0;
  transform: translateX(30px);
}

.step-leave-to {
  opacity: 0;
  transform: translateX(-30px);
}
</style>
